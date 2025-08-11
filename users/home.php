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
    <title>AutoDrive - Premium Cars For You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
<div class="container">
    <a class="navbar-brand" href="#">AutoDrive</a>
    <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
        <   a class="nav-link active" href="#cars">Cars</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#features">Why Choose Us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
        </li>
        <?php if ($Username): ?>
        <li class="nav-item ms-3 text-white">
            <i class="bi bi-person-circle"></i> Hi, <?= htmlspecialchars($Username) ?>
        </li>
        <li class="nav-item ms-3">
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </li>
        <?php else: ?>
        <li class="nav-item ms-3">
            <a href="../auth/login.php" class="btn btn-primary btn-sm">Login</a>
        </li>
        <?php endif; ?>
    </ul>
    </div>
</div>
</nav>

<!-- Hero Section -->
<section class="hero text-center text-white">
<div class="container">
    <h1 class="display-4 fw-bold">Find Your Dream Car Today</h1>
    <p class="lead mb-4">Premium quality cars with unbeatable prices and trusted service.</p>
    <a href="cars.php " class="btn btn-primary btn-lg px-4 me-2">Browse Cars</a>
    <a href="#contact" class="btn btn-outline-light btn-lg px-4">Contact Us</a></div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-light">
    <div class="container">
    <h2 class="text-center mb-5 fw-bold">Why Choose AutoDrive?</h2>
    <div class="row g-4">
    <div class="col-md-4 text-center">
        <i class="bi bi-speedometer2 feature-icon mb-3"></i>
        <h4>Wide Selection</h4>
        <p>Explore a vast inventory of cars from economy to luxury models, handpicked for quality.</p>
    </div>
    <div class="col-md-4 text-center">
        <i class="bi bi-shield-lock feature-icon mb-3"></i>
        <h4>Trusted & Secure</h4>
        <p>All vehicles undergo rigorous inspections for your peace of mind and safety.</p>
    </div>
    <div class="col-md-4 text-center">
        <i class="bi bi-cash-stack feature-icon mb-3"></i>
        <h4>Competitive Pricing</h4>
        <p>Get the best deals with transparent pricing and flexible financing options.</p>
    </div>
    </div>
</div>
</section>

<!-- Cars Preview (sample) -->
<section id="cars" class="py-5">
<div class="container">
    <h2 class="text-center mb-5 fw-bold">Featured Cars</h2>
    <div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <img src="https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Car 1" />
            <div class="card-body">
            <h5 class="card-title">2025 Tesla Model S</h5>
            <p class="card-text">Electric, fast, and luxurious - experience the future of driving.</p>
            <a href="#" class="btn btn-primary">View Details</a>
        </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Car 2" />
            <div class="card-body">
            <h5 class="card-title">2024 BMW 3 Series</h5>
            <p class="card-text">Sporty, elegant, and perfect for everyday luxury.</p>
            <a href="#" class="btn btn-primary">View Details</a>
        </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <img src="https://images.carexpert.com.au/crop/1200/630/vehicles/source-g/9/7/97d64ce6.jpg" class="card-img-top" alt="Car 3" />
            <div class="card-body">
            <h5 class="card-title">2023 Audi A6</h5>
            <p class="card-text">Refined design meets advanced technology for ultimate comfort.</p>
            <a href="#" class="btn btn-primary">View Details</a>
        </div>
        </div>
    </div>
    </div>
</div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5 bg-dark text-white">
<div class="container">
    <h2 class="text-center mb-4 fw-bold">Get In Touch</h2>
    <form class="mx-auto" style="max-width: 600px;">
    <div class="mb-3">
        <label for="contactName" class="form-label">Name</label>
        <input type="text" id="contactName" class="form-control" placeholder="Your name" required />
    </div>
    <div class="mb-3">
        <label for="contactEmail" class="form-label">Email</label>
        <input type="email" id="contactEmail" class="form-control" placeholder="Your email" required />
    </div>
    <div class="mb-3">
        <label for="contactMessage" class="form-label">Message</label>
        <textarea id="contactMessage" rows="4" class="form-control" placeholder="Your message" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary px-5">Send Message</button>
    </form>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<style>
    .hero {
        background: url('https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
        color: white;
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
    }
    .feature-icon {
        font-size: 3rem;
        color: #0d6efd;
    }
    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        letter-spacing: 2px;
    }
</style>