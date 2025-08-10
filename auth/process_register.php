<?php
require_once '../config/db.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);


if ($data && isset($data['username'], $data['email'], $data['password'], $data['confirm_password'])){
    $username = filter_var($data['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    if (!$email){
        echo json_encode([
            "status" => "invalid_email",
            "message" => "Invalid Email Format"
        ]);
        exit;
    }
    $password = $data['password'];
    if (strlen($password) < 8) {
        echo json_encode([
            "status"  => "invalid_password",
            "message" => "Password too short"
        ]);
        exit;
    }
    $confirm_password = $data['confirm_password'];
    if ($password !== $confirm_password){
        echo json_encode([
            "status" => "password_mismatch",
            "message" => "Passwords do not match"
        ]);
        exit;
    }
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    // prepared statement to check if email is existing inside of a database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $ExistingUser = $result->fetch_assoc();
    if ($ExistingUser){
        echo json_encode([
            "status" => "email_taken",
            "message" => "Email is taken."
        ]);
        exit;
    } else {
        // inserting data to database if not existing
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hash_password);
        $stmt->execute();
        if ($stmt->affected_rows > 0){
            echo json_encode([
                "status" => "success",
                "message" => "Registration completed!"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to register!"
            ]);
        }
    }
    //close the prepared statement
    $stmt->close();
}
?>
