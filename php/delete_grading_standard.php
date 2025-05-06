<?php
include "db_connect.php";

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM meat_product_grade WHERE Grade_ID = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>