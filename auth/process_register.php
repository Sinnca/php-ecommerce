<?php
require_once '../config/db.php';
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data && isset($data['username'], $data['email'], $data['password'])){
        $username = filter_var($data['username'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        if (!$email){
            echo '<span class="error">Invalid Email Format</span>';
            exit;
        }
        $password = $data['password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        // prepared statement to check if email is existing inside of a database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $ExistingUser = $result->fetch_assoc();
        if ($ExistingUser){
            echo '<span class="error">Email is taken.</span>';
        } else {
            // inserting data to database if not existing
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $username, $email, $hash_password);
            $stmt->execute();
            if ($stmt->affected_rows > 0){
                echo '<span class="success">Registration completed!</span>';
            } else {
                echo '<span class="error">Failed to register!</span>';
            }
        }
        //close the prepared statement
        $stmt->close();
    }
?>