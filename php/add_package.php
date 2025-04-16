<?php
require_once 'db_connect.php'; // Ensure this file contains your DB connection $conn

header('Content-Type: application/json');

// Validate required fields
if (
    empty($_POST['batch_id']) ||
    empty($_POST['package_type']) ||
    empty($_POST['weight']) ||
    empty($_POST['date_packaged']) ||
    empty($_POST['zip'])
) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$batch_id = $_POST['batch_id'];
$package_type = $_POST['package_type'];
$weight = $_POST['weight'];
$date_packaged = $_POST['date_packaged'];
$zip = $_POST['zip'];

// 1. Get the corresponding Processed_Batch_ID
$processed_query = "SELECT Processed_Batch_ID FROM processed_meat_batch WHERE Batch_ID = ?";
$stmt = $conn->prepare($processed_query);
$stmt->bind_param("i", $batch_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'No processed batch found for the selected batch ID']);
    exit;
}

$row = $result->fetch_assoc();
$processed_batch_id = $row['Processed_Batch_ID'];

// 2. Insert into package table
$insert_query = "INSERT INTO package (Processed_Batch_ID, Package_Type, Weight, Date_Packaged, ZIP) VALUES (?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("isdss", $processed_batch_id, $package_type, $weight, $date_packaged, $zip);

if ($insert_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Insert failed: ' . $conn->error]);
}
?>
