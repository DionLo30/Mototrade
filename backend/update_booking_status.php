<?php
require_once 'config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $new_status = trim($_POST['status']);
    
    // Validate status
    $allowed_statuses = ['pending', 'confirmed', 'cancelled'];
    if (!in_array($new_status, $allowed_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit;
    }
    
    // Update booking status
    $user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("sii", $new_status, $booking_id, $user_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
    
    $stmt->close();
}
?>