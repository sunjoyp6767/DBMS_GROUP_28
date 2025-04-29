<?php
include "db_connect.php";

$query = "
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
    sh.Name as slaughterhouse_name,
    sh.Health_Inspection_Report,
    pt.Name as product_type,
    g.Description as grade_description,
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

$result = $conn->query($query);

if (!$result) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $conn->error]);
    exit();
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'batch_id' => $row['Batch_ID'],
        'date_processed' => $row['Date_Processed'],
        'processed_batch_id' => $row['Processed_Batch_ID'],
        'quality' => $row['Quality'],
        'final_weight' => $row['Final_Weight'],
        'package_id' => $row['Package_ID'],
        'package_type' => $row['Package_Type'],
        'weight' => $row['Weight'],
        'date_packaged' => $row['Date_Packaged'],
        'zip' => $row['ZIP'],
        'transport_id' => $row['Transport_ID'],
        'vehicle_type' => $row['Vehicle_Type'],
        'transport_date' => $row['Transport_Date'],
        'transportation_duration' => $row['Transportation_Duration'],
        'slaughterhouse_name' => $row['slaughterhouse_name'],
        'health_inspection_report' => $row['Health_Inspection_Report'],
        'product_type' => $row['product_type'],
        'grade_description' => $row['grade_description'],
        'quality_score' => $row['Quality_Score']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
