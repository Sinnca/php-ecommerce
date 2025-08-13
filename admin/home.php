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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar d-flex flex-column p-0">
        <h2 class="border-bottom border-secondary mb-0">ShopAdmin</h2>
        <a href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a class="d-flex align-items-center justify-content-between" 
            data-bs-toggle="collapse" href="#productsMenu" role="button" aria-expanded="false" aria-controls="productsMenu">
            <span><i class="bi bi-box-seam"></i> Products</span>
            <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse ps-4" id="productsMenu">
            <a href="view_products.php" class="d-block mt-1"><i class="bi bi-list"></i> View Products</a>
            <a href="manage_products.php" class="d-block mt-1"><i class="bi bi-gear"></i> Manage Products</a>
        </div>
        <a href="orders.php"><i class="bi bi-cart-check"></i> Orders</a>
        <hr class="bg-light">
        <a href="../auth/logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="content">
        <h1 class="mb-4">Welcome back, <?php echo htmlspecialchars($Username); ?> 👋</h1>
        <p>Here’s what’s happening with your store today.</p>

        <!-- Dashboard cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Orders</h6>
                        <h3>1,245</h3>
                        <small class="text-success">+12% from last month</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Revenue</h6>
                        <h3>$54,300</h3>
                        <small class="text-success">+8% from last month</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Products</h6>
                        <h3>320</h3>
                        <small class="text-muted">Updated daily</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Customers</h6>
                        <h3>890</h3>
                        <small class="text-muted">Since opening</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4>Recent Orders</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1001</td>
                        <td>John Doe</td>
                        <td>$120.00</td>
                        <td><span class="badge bg-success">Completed</span></td>
                        <td>2025-08-10</td>
                    </tr>
                    <tr>
                        <td>#1002</td>
                        <td>Jane Smith</td>
                        <td>$89.50</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>2025-08-09</td>
                    </tr>
                    <tr>
                        <td>#1003</td>
                        <td>David Johnson</td>
                        <td>$240.75</td>
                        <td><span class="badge bg-danger">Cancelled</span></td>
                        <td>2025-08-09</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
