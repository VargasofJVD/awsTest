<?php
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $habitat = $_POST['habitat'];
    
    // Handle file upload
    $target_dir = "../public/uploads/animals/";
    $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $file_name;
    
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
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Save to database
        $image_url = "/awsTest/public/uploads/animals/" . $file_name;
        $stmt = $pdo->prepare("INSERT INTO animals (name, habitat, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$name, $habitat, $image_url]);
        
        header("Location: index.php");
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>