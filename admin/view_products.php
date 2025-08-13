<?php
session_start();
require_once '../config/db.php';

$Email = $_SESSION['Email'];
$Username = $_SESSION['Username'];
$id = $_SESSION['id'];
$Role = $_SESSION['Role'];

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Browse Products - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Products</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($product = mysqli_fetch_assoc($result)): ?>
        <div class="col">
            <div class="card product-card">
            <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
            <div class="product-details">
                <h5><?= htmlspecialchars($product['name']) ?></h5>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p><strong>Stock:</strong> <?= (int)$product['stock'] ?></p>
                <p class="price">$<?= number_format($product['price'], 2) ?></p>
                <button>View</button>
            </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<style>
body {
    background-color: #f8f9fa;
    }
.product-card {
    border-radius: 8px;
    box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
    }
.product-card:hover {
    transform: translateY(-8px);
    }
.product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    }
.product-details {
    padding: 1rem;
    }
.price {
    font-weight: 700;
    color: #28a745;
    font-size: 1.2rem;
    }
</style>