<?php
include "db_connect.php";

$query = "SELECT g.Grade_ID, t.Name as product_name, g.Description, g.Quality_Score, 
                 p.Final_Weight, s.Name as slaughterhouse_name, 
                 s.Health_Inspection_Report, s.Processing_Time,
                 g.Inspector_Name, g.Inspection_Notes
          FROM meat_product_grade g
          JOIN meat_product_type t ON g.Product_Type_ID = t.Product_Type_ID
          LEFT JOIN meat_batch b ON g.Grade_ID = b.Grade_ID
          LEFT JOIN processed_meat_batch p ON b.Batch_ID = p.Batch_ID
          LEFT JOIN slaughtering_house s ON p.House_ID = s.House_ID";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'grade_id' => $row['Grade_ID'],
        'product_name' => $row['product_name'],
        'description' => $row['Description'],
        'quality_score' => $row['Quality_Score'],
        'final_weight' => $row['Final_Weight'],
        'slaughterhouse_name' => $row['slaughterhouse_name'],
        'health_inspection_report' => $row['Health_Inspection_Report'],
        'processing_time' => $row['Processing_Time'],
        'inspector_name' => $row['Inspector_Name'],
        'inspection_notes' => $row['Inspection_Notes']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>