<?php
include "db_connect.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT g.Grade_ID, t.Name as product_name, g.Description, g.Quality_Score, 
                 g.Average_Weight, g.Texture_Quality, g.Date_of_Grading, 
                 b.Quantity, b.Cattle_ID, g.Inspector_Name, g.Inspection_Notes
          FROM meat_product_grade g
          JOIN meat_product_type t ON g.Product_Type_ID = t.Product_Type_ID
          LEFT JOIN meat_batch b ON g.Grade_ID = b.Grade_ID";

if (!empty($search)) {
    $query .= " WHERE t.Name LIKE ? OR g.Description LIKE ? OR g.Quality_Score LIKE ? 
                OR g.Texture_Quality LIKE ? OR g.Inspector_Name LIKE ?";
    $searchParam = "%$search%";
}

$stmt = $conn->prepare($query);

if (!empty($search)) {
    $stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
}

$stmt->execute();
$result = $stmt->get_result();

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
        'cattle_id' => $row['Cattle_ID'],
        'inspector_name' => $row['Inspector_Name'],
        'inspection_notes' => $row['Inspection_Notes']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>