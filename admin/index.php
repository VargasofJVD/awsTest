<?php
require_once '../includes/db.php';

// Fetch existing animals
$stmt = $pdo->query("SELECT * FROM animals ORDER BY created_at DESC");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Upload Animal Information</h2>
        
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="name" class="form-label">Animal Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <div class="mb-3">
                <label for="habitat" class="form-label">Habitat</label>
                <input type="text" class="form-control" id="habitat" name="habitat" required>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <h3>Existing Animals</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Habitat</th>
                    <th>Image</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($animals as $animal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($animal['name']); ?></td>
                    <td><?php echo htmlspecialchars($animal['habitat']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($animal['image_url']); ?>" height="50"></td>
                    <td><?php echo $animal['created_at']; ?></td>
                    <td>
                        <form action="delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this animal?');">
                            <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>