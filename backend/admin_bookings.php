<?php
require_once 'config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

// Get all bookings with user info
$query = "SELECT b.*, u.email, u.first_name, u.last_name, u.phone 
          FROM bookings b 
          JOIN users u ON b.user_id = u.id 
          ORDER BY b.created_at DESC";

$result = $conn->query($query);

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode(['success' => true, 'bookings' => $bookings]);
?>