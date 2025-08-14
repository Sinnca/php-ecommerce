<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);


if ($data && isset($data['id'])){
    $product_id = $data['id'];

    $sql = $conn->prepare("DELETE FROM products WHERE id = ?");
    $sql->bind_param('i', $product_id);

    if ($sql->execute()) {
        if ($sql->affected_rows > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "Product deleted successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Database execution failed: " . $sql->error
            ]);
        }
    }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Product id not set"
            ]);
    }
    $sql->close();
?>

