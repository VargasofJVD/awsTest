<?php
require_once '../includes/db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // First get the image URL/path
    $stmt = $pdo->prepare("SELECT image_url FROM animals WHERE id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch();
    
    if ($animal) {
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM animals WHERE id = ?");
        $stmt->execute([$id]);
        
        // Delete the actual file
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $animal['image_url'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    header("Location: index.php");
    exit();
}
?>