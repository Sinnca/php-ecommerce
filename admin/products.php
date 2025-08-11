<?php 
session_start();
require_once '../config/db.php';

$Email = $_SESSION['Email'];
$Username = $_SESSION['Username']; 
$id = $_SESSION['id'];
$Role = $_SESSION['Role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Product - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>
    <div class="sidebar d-flex flex-column p-0">
        <h2 class="border-bottom border-secondary mb-0">ShopAdmin</h2>
        <a href="home.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="products.php"><i class="bi bi-box-seam"></i> Products</a>
        <a href="#"><i class="bi bi-cart-check"></i> Orders</a>
        <hr class="bg-light" />
        <a href="../auth/logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="content">
        <h1 class="mb-4">Add New Product</h1>

        <div class="card shadow-sm border-0 p-4">
            <form id="product" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required />
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Add Product
                </button>
                <p id="response"></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
    document.getElementById('product').addEventListener('submit', async function (event) {
        event.preventDefault();

        let name = document.getElementById('name').value;
        let description = document.getElementById('description').value;

        if (!name.trim()) {
            document.getElementById('response').textContent = "Name is required";
            document.getElementById('response').style.color = "red";
            return;
        }
        if (!description.trim()) {
            document.getElementById('response').textContent = "Description is required";
            document.getElementById('response').style.color = "red";
            return;
        }

        let formData = new FormData(this); // send entire form including file

        try {
            let response = await fetch("add_product.php", {
                method: "POST",
                body: formData, 
            });

            let result = await response.json();

            if (result.status === "success") {
                document.getElementById('response').textContent = result.message;
                document.getElementById('response').style.color = "green";
                this.reset();
            } else {
                document.getElementById('response').textContent = result.message;
                document.getElementById('response').style.color = "red";
            }
        } catch (error) {
            console.error(error);
            document.getElementById('response').textContent = "An error occurred, please try again.";
            document.getElementById('response').style.color = "red";
        }
    });
</script>

<style>
    body {
        min-height: 100vh;
        display: flex;
        background-color: #f8f9fa;
    }
    .sidebar {
        min-width: 250px;
        background-color: #212529;
        color: white;
    }
    .sidebar h2 {
        font-size: 1.5rem;
        padding: 20px;
    }
    .sidebar a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        font-size: 1rem;
    }
    .sidebar a:hover {
        background-color: #343a40;
    }
    .sidebar .bg-primary {
        background-color: #0d6efd !important;
    }
    .content {
        flex: 1;
        padding: 20px;
    }
</style>