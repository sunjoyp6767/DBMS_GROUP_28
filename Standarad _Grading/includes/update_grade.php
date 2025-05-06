<?php
require_once __DIR__ . '/../../php/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grade_id = $_POST['grade_id'];
    $description = $_POST['description'];
    $quality_score = $_POST['quality_score'];
    $average_weight = $_POST['average_weight'];
    $texture_quality = $_POST['texture_quality'];
    $date_of_grading = $_POST['date_of_grading'];
    $product_type_id = $_POST['product_type_id'];

    try {
        $query = "UPDATE meat_product_grade 
                 SET Description = ?, Quality_Score = ?, Average_Weight = ?, 
                     Texture_Quality = ?, Date_of_Grading = ?, Product_Type_ID = ?
                 WHERE Grade_ID = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sddssii", $description, $quality_score, $average_weight, 
                         $texture_quality, $date_of_grading, $product_type_id, $grade_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Grade updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update grade']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?> 