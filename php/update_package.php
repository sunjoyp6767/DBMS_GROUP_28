<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

$id = $_POST['package_id'] ?? '';
$type = $_POST['package_type'] ?? '';
$weight = $_POST['weight'] ?? '';
$date = $_POST['date_packaged'] ?? '';
$zip = $_POST['zip'] ?? '';

if (!$id || !$type || !$weight || !$date || !$zip) {
  echo json_encode(['success' => false, 'message' => 'Missing fields']);
  exit;
}

$stmt = $conn->prepare("UPDATE package SET Package_Type=?, Weight=?, Date_Packaged=?, ZIP=? WHERE Package_ID=?");
$stmt->bind_param("sdssi", $type, $weight, $date, $zip, $id);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>
