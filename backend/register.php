<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    
    // Validate inputs
    if (empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered']);
        exit;
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //Validate First Name
    if (!preg_match("/^[a-zA-Z\s'-]+$/", $first_name)) {
        echo json_encode(['success' => false,'message' => 'First name contains invalid characters']);
        exit;
    }

    //Validate Last Name
    if (!preg_match("/^[a-zA-Z\s'-]+$/", $last_name)) {
        echo json_encode(['success' => false,'message' => 'Last name contains invalid characters']);
        exit;
    }

    //Validate Phone
    if (!empty($phone) && !preg_match('/^\+?[0-9]+$/', $phone)) {
        echo json_encode(['success' => false,'message' => 'Invalid phone number']);
        exit;
    }
    
    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (email, password, first_name, last_name, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $hashed_password, $first_name, $last_name, $phone);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed']);
    }
    
    $stmt->close();
}
?>