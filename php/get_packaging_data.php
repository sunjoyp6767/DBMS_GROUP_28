<?php
include "db_connect.php";

$query = "SELECT pk.Package_ID, pk.Processed_Batch_ID, pk.Package_Type, 
                 pk.Weight, pk.Date_Packaged, pk.ZIP, pk.Storage_Temperature, 
                 pk.Expiration_Date, p.Quality, b.Batch_ID, t.Name as product_name
          FROM package pk
          JOIN processed_meat_batch p ON pk.Processed_Batch_ID = p.Processed_Batch_ID
          JOIN meat_batch b ON p.Batch_ID = b.Batch_ID
          JOIN meat_product_grade g ON b.Grade_ID = g.Grade_ID
          JOIN meat_product_type t ON g.Product_Type_ID = t.Product_Type_ID";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'package_id' => $row['Package_ID'],
        'processed_batch_id' => $row['Processed_Batch_ID'],
        'package_type' => $row['Package_Type'],
        'weight' => $row['Weight'],
        'date_packaged' => $row['Date_Packaged'],
        'zip' => $row['ZIP'],
        'storage_temperature' => $row['Storage_Temperature'],
        'expiration_date' => $row['Expiration_Date'],
        'quality' => $row['Quality'],
        'batch_id' => $row['Batch_ID'],
        'product_name' => $row['product_name']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>