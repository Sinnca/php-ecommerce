<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if ($data && isset($data['name'], $data['description'], $data['stock'], $data['price'], $data['id'])) {
    $new_name = $data['name'] ?? "";
    $new_description = $data['description'] ?? "";
    $new_stock = (int)($data['stock'] ?? 0);
    $new_price = (float)($data['price'] ?? 0);
    $product_id = (int)($data['id'] ?? 0);

    $sql = $conn->prepare("UPDATE products SET name = ?, description = ?, stock = ?, price = ? WHERE id = ?");
    $sql->bind_param('ssidi', $new_name, $new_description, $new_stock, $new_price, $product_id);
    
    if ($sql->execute()) {
        if ($sql->affected_rows > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "Product updated successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "failed",
                "message" => "Failed to update, Please try again"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "failed",
            "message" => "Failed to execute update query"
        ]);
    }

    $sql->close();
} else {
    echo json_encode([
        "status" => "failed",
        "message" => "Invalid request"
    ]);
}