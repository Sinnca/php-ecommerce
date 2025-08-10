<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);


if ($data && isset($data['email'], $data['password'])) {
    $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    $password = $data['password'];
    if (!$email) {
    echo json_encode([
        "status" => "invalid_email",
        "message" => "Invalid Email"
    ]);
    exit;
}

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
    echo json_encode([
        "status" => "missing",
        "message" => "Email not found"
    ]);
    exit;
}
    if ($user && password_verify($password, $user['password'])) {
    $_SESSION['Email'] = $user['email'];
    $_SESSION['Username'] = $user['username'];
    $_SESSION['id'] = $user['id'];
    $_SESSION['Role'] = $user['role'];

    if ($user['role'] === 'admin') {
        $redirect = '/week8/admin/home.php';
    } else {
        $redirect = '/week8/users/home.php';
    }
        echo json_encode(['status' => 'success','redirect' => $redirect]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
    }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing email or password']);
    }
    exit;
