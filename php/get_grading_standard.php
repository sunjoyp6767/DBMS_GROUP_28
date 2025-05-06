<?php
include "db_connect.php";

$id = $_GET['id'];

$query = "SELECT g.*, p.Name as product_name, b.Quantity 
          FROM meat_product_grade g
          JOIN meat_product_type p ON g.Product_Type_ID = p.Product_Type_ID
          JOIN meat_batch b ON g.Grade_ID = b.Grade_ID
          WHERE g.Grade_ID = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Grading standard not found']);
}

$conn->close();
?>