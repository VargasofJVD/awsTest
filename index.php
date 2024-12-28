<!-- index.php (in root directory) -->
<?php
require_once 'includes/db.php';

// Fetch all animals
$stmt = $pdo->query("SELECT * FROM animals ORDER BY created_at DESC");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Animal Gallery</h1>
        
        <div class="row">
            <?php foreach($animals as $animal): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($animal['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($animal['name']); ?></h5>
                        <p class="card-text">Habitat: <?php echo htmlspecialchars($animal['habitat']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>