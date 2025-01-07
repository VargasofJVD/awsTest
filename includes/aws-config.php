<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'YOUR_REGION', // e.g., us-east-1
    'credentials' => [
        'key'    => 'YOUR_ACCESS_KEY_ID',
        'secret' => 'YOUR_SECRET_ACCESS_KEY'
    ]
]);

// Function to upload file to S3
function uploadToS3($s3, $file_tmp, $file_name) {
    $bucket = 'YOUR_BUCKET_NAME';
    
    try {
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key'    => 'animals/' . $file_name,
            'SourceFile' => $file_tmp,
            'ACL'    => 'public-read'
        ]);
        return $result['ObjectURL'];
    } catch (AwsException $e) {
        error_log("Error uploading to S3: " . $e->getMessage());
        throw $e;
    }
}
?>