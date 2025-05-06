<?php
require_once __DIR__ . '/../../php/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_type_id = $_POST['product_type_id'];
    $description = $_POST['description'];
    $quality_score = $_POST['quality_score'];
    $average_weight = $_POST['average_weight'];
    $texture_quality = $_POST['texture_quality'];
    $date_of_grading = $_POST['date_of_grading'];

    try {
        // Start transaction
        $conn->begin_transaction();

        // Check if this product type already has a grade
        $check_query = "SELECT COUNT(*) as count FROM meat_product_grade WHERE Product_Type_ID = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("i", $product_type_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            throw new Exception("This product type already has a grade assigned. Each product type can only have one grade.");
        }

        // Get the next available Grade_ID
        $get_next_id = "SELECT MAX(Grade_ID) as max_id FROM meat_product_grade";
        $result = $conn->query($get_next_id);
        $row = $result->fetch_assoc();
        $next_grade_id = ($row['max_id'] ?? 0) + 1;

        // Insert into meat_product_grade
        $query = "INSERT INTO meat_product_grade (Grade_ID, Description, Quality_Score, Average_Weight, 
                                                Texture_Quality, Date_of_Grading, Product_Type_ID) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isddssi", $next_grade_id, $description, $quality_score, $average_weight, 
                         $texture_quality, $date_of_grading, $product_type_id);

        if ($stmt->execute()) {
            // Insert a corresponding record in meat_batch
            $batch_query = "INSERT INTO meat_batch (Date_Processed, Quantity, Grade_ID, Cattle_ID, Weight) 
                           VALUES (?, ?, ?, ?, ?)";
            $batch_stmt = $conn->prepare($batch_query);
            
            // Set default values for meat_batch
            $date_processed = date('Y-m-d');
            $quantity = 1; // Default quantity
            $cattle_id = 1; // Default cattle ID
            $weight = $average_weight; // Use the average weight from grade
            
            $batch_stmt->bind_param("siiid", $date_processed, $quantity, $next_grade_id, $cattle_id, $weight);
            
            if ($batch_stmt->execute()) {
                // Commit the transaction if both inserts are successful
                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'Grade added successfully']);
            } else {
                throw new Exception("Failed to create batch record");
            }
        } else {
            throw new Exception("Failed to add grade");
        }
    } catch(Exception $e) {
        // Roll back the transaction if any error occurred
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 