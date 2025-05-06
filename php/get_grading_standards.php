<?php
include "db_connect.php";

$query = "SELECT g.Grade_ID, t.Name as product_name, g.Description, g.Quality_Score, 
                 g.Average_Weight, g.Texture_Quality, g.Date_of_Grading, 
                 b.Quantity, g.Inspector_Name, g.Inspection_Notes
          FROM meat_product_grade g
          JOIN meat_product_type t ON g.Product_Type_ID = t.Product_Type_ID
          LEFT JOIN meat_batch b ON g.Grade_ID = b.Grade_ID";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'grade_id' => $row['Grade_ID'],
        'product_name' => $row['product_name'],
        'description' => $row['Description'],
        'quality_score' => $row['Quality_Score'],
        'average_weight' => $row['Average_Weight'],
        'texture_quality' => $row['Texture_Quality'],
        'date_of_grading' => $row['Date_of_Grading'],
        'quantity' => $row['Quantity'],
        'inspector_name' => $row['Inspector_Name'],
        'inspection_notes' => $row['Inspection_Notes']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>