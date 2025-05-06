<?php
header('Content-Type: application/json');
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['package_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing package_id']);
    exit;
}

$package_id = intval($_POST['package_id']);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

// Step 1: Delete from transport_package
$stmt1 = $conn->prepare("DELETE FROM transport_package WHERE Package_ID = ?");
if (!$stmt1) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed (transport_package): ' . $conn->error]);
    exit;
}
$stmt1->bind_param("i", $package_id);
$stmt1->execute();
$stmt1->close();

// Step 2: Delete from package
$stmt2 = $conn->prepare("DELETE FROM package WHERE Package_ID = ?");
if (!$stmt2) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed (package): ' . $conn->error]);
    exit;
}
$stmt2->bind_param("i", $package_id);
if ($stmt2->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt2->error]);
}
$stmt2->close();

$conn->close();
?>