<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Please login to book a car']);
        exit;
    }
    
    $user_id = $_SESSION['user_id'];
    $car_name = trim($_POST['car_name']);
    $car_price = floatval($_POST['car_price']);
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $insurance = isset($_POST['insurance']) && $_POST['insurance'] === 'true' ? 'Yes' : 'No';
    $gps = isset($_POST['gps']) && $_POST['gps'] === 'true' ? 'Yes' : 'No';
    $child_seat = isset($_POST['child_seat']) && $_POST['child_seat'] === 'true' ? 'Yes' : 'No';
    $special_requests = trim($_POST['special_requests']);
    $total_cost = floatval($_POST['total_cost']);
    
    // Validate dates
    if (strtotime($pickup_date) >= strtotime($return_date)) {
        echo json_encode(['success' => false, 'message' => 'Return date must be after pickup date']);
        exit;
    }
    
    // Check availability (optional - prevents double booking)
    $stmt = $conn->prepare("SELECT id FROM bookings WHERE car_name = ? AND status != 'cancelled' AND ((pickup_date BETWEEN ? AND ?) OR (return_date BETWEEN ? AND ?))");
    $stmt->bind_param("sssss", $car_name, $pickup_date, $return_date, $pickup_date, $return_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'This car is already booked for the selected dates']);
        exit;
    }
    
    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, car_name, car_price, pickup_date, return_date, pickup_location, return_location, insurance, gps, child_seat, special_requests, total_cost, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isdssssssssd", $user_id, $car_name, $car_price, $pickup_date, $return_date, $pickup_location, $return_location, $insurance, $gps, $child_seat, $special_requests, $total_cost);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking successful', 'booking_id' => $stmt->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking failed: ' . $conn->error]);
    }
    
    $stmt->close();
}
?>