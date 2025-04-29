<?php
include "db_connect.php";

$sql = "
SELECT
    b.Batch_ID,
    b.Date_Processed,
    p.Processed_Batch_ID,
    p.Quality,
    p.Final_Weight,
    pk.Package_ID,
    pk.Package_Type,
    pk.Weight,
    pk.Date_Packaged,
    pk.ZIP,
    t.Transport_ID,
    t.Vehicle_Type,
    t.Transport_Date,
    t.Transportation_Duration,
    sh.Name AS slaughterhouse_name,
    sh.Health_Inspection_Report,
    pt.Name AS product_type,
    g.Description AS grade_description,
    g.Quality_Score
FROM meat_batch b
JOIN meat_product_grade g ON b.Grade_ID = g.Grade_ID
JOIN meat_product_type pt ON g.Product_Type_ID = pt.Product_Type_ID
LEFT JOIN processed_meat_batch p ON b.Batch_ID = p.Batch_ID
LEFT JOIN slaughtering_house sh ON p.House_ID = sh.House_ID
LEFT JOIN package pk ON p.Processed_Batch_ID = pk.Processed_Batch_ID
LEFT JOIN transport_package tp ON pk.Package_ID = tp.Package_ID
LEFT JOIN transport t ON tp.Transport_ID = t.Transport_ID
ORDER BY b.Batch_ID
";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => $conn->error]);
    exit;
}

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = array_change_key_case($row, CASE_LOWER);
}

header('Content-Type: application/json');
echo json_encode($data);
?>
