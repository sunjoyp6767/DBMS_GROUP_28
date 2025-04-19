<?php
require_once 'db_connect.php';

$id = $_POST['transport_id'];
$vehicle = $_POST['vehicle_type'];
$plate = $_POST['license_plate'];
$date = $_POST['transport_date'];
$duration = $_POST['transportation_duration'];

$stmt = $conn->prepare("UPDATE transport SET Vehicle_Type=?, License_Plate=?, Transport_Date=?, Transportation_Duration=? WHERE Transport_ID=?");
$stmt->bind_param("ssssi", $vehicle, $plate, $date, $duration, $id);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>
