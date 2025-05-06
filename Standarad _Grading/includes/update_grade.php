<?php
require_once __DIR__ . '/../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $grade_id = intval($_POST['grade_id']);
        $description = $conn->real_escape_string($_POST['description']);
        $quality_score = floatval($_POST['quality_score']);
        $average_weight = floatval($_POST['average_weight']);
        $texture_quality = $conn->real_escape_string($_POST['texture_quality']);
        $date_of_grading = $conn->real_escape_string($_POST['date_of_grading']);
        $product_type_id = intval($_POST['product_type_id']);

        $query = "UPDATE meat_product_grade 
                 SET Description = '$description',
                     Quality_Score = $quality_score,
                     Average_Weight = $average_weight,
                     Texture_Quality = '$texture_quality',
                     Date_of_Grading = '$date_of_grading',
                     Product_Type_ID = $product_type_id
                 WHERE Grade_ID = $grade_id";

        if ($conn->query($query)) {
            header('Location: ../grading_standard.php?success=2');
            exit;
        } else {
            throw new Exception($conn->error);
        }
    } catch(Exception $e) {
        header('Location: ../grading_standard.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
?> 