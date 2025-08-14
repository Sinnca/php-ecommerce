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
            <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" 
                class="card-img-top"
                alt="<?= htmlspecialchars($product['name']) ?>" />
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                <p><strong>Stock:</strong> <?= (int)$product['stock'] ?></p>
                <p class="price">$<?= number_format($product['price'], 2) ?></p>
                <button 
                    class="btn btn-warning btn-sm"
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal"
                    data-id="<?= $product['id'] ?>"
                    data-name="<?= htmlspecialchars($product['name']) ?>"
                    data-description="<?= htmlspecialchars($product['description']) ?>"
                    data-stock="<?= (int)$product['stock'] ?>"
                    data-price="<?= number_format($product['price'], 2) ?>"
                >
                    Edit
                </button>
                <button 
                    class="btn btn-danger btn-sm"
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteModal"
                    data-id="<?= $product['id'] ?>"
                >
                    Delete
                </button>

            </div>
        </div>
    </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
        Are you sure you want to delete this product?
    </div>
    <div class="modal-footer">
        <form id="deleteForm">
            <input type="hidden" name="id" id="deleteProductId">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
        <p id="response" class="text-center mt-2"></p>
    </div>
</div>
</div>

<script>
    //set the id of the product in  the modal
document.getElementById('deleteModal').addEventListener('show.bs.modal', function(event) {
    let button = event.relatedTarget;
    let productId = button.getAttribute('data-id');
    document.getElementById('deleteProductId').value = productId;
});
    // delete script
document.getElementById('deleteForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    let id = document.getElementById('deleteProductId').value;

    try {
        let response = await fetch('delete_product.php', {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        });

        let result = await response.json();
        let responseElem = document.getElementById('response');

        if (result.status === "success") {
            responseElem.textContent = result.message;
            responseElem.style.color = "green";
        } else if (result.status === "error") {
            responseElem.textContent = result.message;
            responseElem.style.color = "red"; 
        }
        else {
            responseElem.textContent = result.message;
            responseElem.style.color = "red";
        }
    } catch (error) {
        console.error(error);
        let responseElem = document.getElementById('response');
        responseElem.textContent = "An error occurred, Please try again";
        responseElem.style.color = "red";
    }
});
</script>




<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
        
        <div class="modal-body">
        <form id="form" class="needs-validation" novalidate>
            <input type="hidden" id="id" name="id">

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" required>
        </div>

        <div class="text-end">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
        <p id="response" class="mt-2"></p>
        </form>
    </div>

    </div>
</div>
</div>

<script>
    // modal script to get the product's data to pass in  server side process
    let editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
    let button = event.relatedTarget;

    // Get values from data attributes
    let id = button.getAttribute('data-id');
    let name = button.getAttribute('data-name');
    let description = button.getAttribute('data-description');
    let stock = button.getAttribute('data-stock');
    let price = button.getAttribute('data-price');

    // Populate form fields
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('description').value = description;
    document.getElementById('stock').value = stock;
    document.getElementById('price').value = price;
});

document.getElementById('form').addEventListener('submit', async function(event) {
    event.preventDefault();


    let id = document.getElementById('id').value;
    let name = document.getElementById('name').value;
    let description = document.getElementById('description').value;
    let stock = document.getElementById('stock').value;
    let price = document.getElementById('price').value;

    try {
        let response = await fetch('update_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: id,
                name: name,
                description: description,
                stock: stock,
                price: price
            }),
        });

        let result = await response.json();
        if (result.status === "success"){
            document.getElementById('response').textContent = result.message;
            document.getElementById('response').style.color = "green";
        } else {
            document.getElementById('response').textContent = result.message;
            document.getElementById('response').style.color = "red";
        }

    } catch (error) {
        console.error(error);
        document.getElementById('response').textContent = "An error occurred, Please try again.";
        document.getElementById('response').style.color = "red";
    }
});
</script>
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