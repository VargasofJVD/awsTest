//php start tag
//require_once '../includes/db.php';

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //  $name = $_POST['name'];
    //$habitat = $_POST['habitat'];
    
    // Handle file upload
    //$target_dir = "../public/uploads/animals/";
    //$file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    //$file_name = uniqid() . '.' . $file_extension;
    //$target_file = $target_dir . $file_name;
    
    // Check if image file is actual image
    //if(getimagesize($_FILES["image"]["tmp_name"]) === false) {
     //   die("File is not an image.");
    //}
    
    // Check file size (5MB max)
    //if ($_FILES["image"]["size"] > 5000000) {
      //  die("File is too large.");
    //}
    
    // Allow certain file formats
    //if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
      //  die("Sorry, only JPG, JPEG & PNG files are allowed.");
    //}
    
    //if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Save to database
      //  $image_url = "/awsTest/public/uploads/animals/" . $file_name;
        //$stmt = $pdo->prepare("INSERT INTO animals (name, habitat, image_url) VALUES (?, ?, ?)");
        //$stmt->execute([$name, $habitat, $image_url]);
        
       // header("Location: index.php");
        //exit();
    //} else {
      //  echo "Sorry, there was an error uploading your file.";
    //}
//}
// php end tag



//modified s3 upload
// admin/upload.php

<?php
require_once '../vendor/autoload.php';
require_once '../includes/db.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// AWS Configuration
$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'YOUR_REGION', // e.g., us-east-1
    'credentials' => [
        'key'    => 'YOUR_ACCESS_KEY_ID',
        'secret' => 'YOUR_SECRET_ACCESS_KEY',
    ]
]);

$bucketName = 'animal-gallery-images';
$cloudFrontDomain = 'YOUR_CLOUDFRONT_DOMAIN.cloudfront.net';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $habitat = $_POST['habitat'];
    
    // Handle file upload
    $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $file_extension;
    
    // Check if image file is actual image
    if(getimagesize($_FILES["image"]["tmp_name"]) === false) {
        die("File is not an image.");
    }
    
    // Check file size (5MB max)
    if ($_FILES["image"]["size"] > 5000000) {
        die("File is too large.");
    }
    
    // Allow certain file formats
    if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
        die("Sorry, only JPG, JPEG & PNG files are allowed.");
    }
    
    try {
        // Upload to S3
        $result = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key'    => 'animals/' . $file_name,
            'SourceFile' => $_FILES["image"]["tmp_name"],
            'ContentType' => $_FILES["image"]["type"],
            'ACL'    => 'private', // Keep private since we're using CloudFront
        ]);
        
        // Generate CloudFront URL
        $cloudFrontUrl = 'https://' . $cloudFrontDomain . '/animals/' . $file_name;
        
        // Save to database with CloudFront URL
        $stmt = $pdo->prepare("INSERT INTO animals (name, habitat, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$name, $habitat, $cloudFrontUrl]);
        
        header("Location: index.php");
        exit();
        
    } catch (AwsException $e) {
        die("Error uploading to AWS: " . $e->getMessage());
    }
}
?>