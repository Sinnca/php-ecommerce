<?php
session_start();
require_once '../config/db.php'; 

header('Content-Type: application/json'); // Tell client that response will be JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';    
    $description = $_POST['description'] ?? '';   
    $stock = (int)($_POST['stock'] ?? 0);         
    $price = (float)($_POST['price'] ?? 0);        

    // Check if a file named 'image' was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

    $uploadDir = '../uploads/'; // Directory where uploaded images will be saved

    // Create the upload directory if it doesn't exist (with 0755 permissions)
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Create a unique filename using current timestamp + original file name
    $fileName = time() . '_' . basename($_FILES['image']['name']);

    // Full path where file will be saved on server
    $uploadPath = $uploadDir . $fileName;

    // Move the uploaded file from temporary location to upload directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
    $stmt = $conn->prepare("INSERT INTO products (name, description, stock, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssids", $name, $description, $stock, $price, $fileName);
    if ($stmt->execute()) {
        echo json_encode([
        "status" => "success",
        "message" => "Product Added Successfully"
    ]);
    } else {
        echo json_encode([
        "status" => "failed",
        "message" => "Failed to add product."
    ]);
    }
        $stmt->close(); 

    } else {
    // Send failure JSON response if file move/upload failed
    echo json_encode([
    "status" => "failed",
    "message" => "Failed to upload image."
    ]);
    }

    } else {
    // Send failure JSON response if no image was uploaded or there was an error
    echo json_encode([
    "status" => "failed",
    "message" => "Image is required."
    ]);
    }
    exit; 
}
?>
