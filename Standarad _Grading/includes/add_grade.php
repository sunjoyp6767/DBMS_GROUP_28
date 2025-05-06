<?php
require_once __DIR__ . '/../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get the next available Grade_ID
        $result = $conn->query("SELECT MAX(Grade_ID) as max_id FROM meat_product_grade");
        $row = $result->fetch_assoc();
        $next_id = ($row['max_id'] ?? 0) + 1;

        $description = $conn->real_escape_string($_POST['description']);
        $quality_score = floatval($_POST['quality_score']);
        $average_weight = floatval($_POST['average_weight']);
        $texture_quality = $conn->real_escape_string($_POST['texture_quality']);
        $date_of_grading = $conn->real_escape_string($_POST['date_of_grading']);
        $product_type_id = intval($_POST['product_type_id']);

        $query = "INSERT INTO meat_product_grade (
            Grade_ID, Description, Quality_Score, Average_Weight, 
            Texture_Quality, Date_of_Grading, Product_Type_ID
        ) VALUES (
            $next_id, '$description', $quality_score, $average_weight,
            '$texture_quality', '$date_of_grading', $product_type_id
        )";

        if ($conn->query($query)) {
            header('Location: ../grading_standard.php?success=1');
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