<?php
include "db_connect.php";

$query = "SELECT Cattle_ID, Breed FROM cattle";
$result = $conn->query($query);

$cattle = [];
while ($row = $result->fetch_assoc()) {
    $cattle[] = $row;
}

header('Content-Type: application/json');
echo json_encode($cattle);
?>