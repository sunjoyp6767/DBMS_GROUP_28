<?php
require_once 'db_connect.php';

$vehicle = $_POST['vehicle_type'] ?? null;
$plate = $_POST['license_plate'] ?? null;
$date = $_POST['transport_date'] ?? null;
$duration = $_POST['transportation_duration'] ?? null;

if (!$vehicle || !$plate || !$date || !$duration) {
  echo json_encode(['success' => false, 'message' => 'Missing fields']);
  exit;
}

$stmt = $conn->prepare("INSERT INTO transport (Vehicle_Type, License_Plate, Transport_Date, Transportation_Duration) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $vehicle, $plate, $date, $duration);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>
