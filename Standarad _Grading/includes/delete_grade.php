<?php
require_once __DIR__ . '/../../php/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grade_id = $_POST['grade_id'];

    try {
        // Start transaction
        $conn->begin_transaction();

        // Step 1: Get all batch IDs related to this grade
        $batch_query = "SELECT Batch_ID FROM meat_batch WHERE Grade_ID = ?";
        $stmt = $conn->prepare($batch_query);
        $stmt->bind_param("i", $grade_id);
        $stmt->execute();
        $batch_result = $stmt->get_result();

        if ($batch_result && $batch_result->num_rows > 0) {
            while ($batch = $batch_result->fetch_assoc()) {
                $batch_id = $batch['Batch_ID'];
                
                // Step 2: Get all processed batch IDs related to this batch
                $processed_query = "SELECT Processed_Batch_ID FROM processed_meat_batch WHERE Batch_ID = ?";
                $stmt = $conn->prepare($processed_query);
                $stmt->bind_param("i", $batch_id);
                $stmt->execute();
                $processed_result = $stmt->get_result();

                if ($processed_result && $processed_result->num_rows > 0) {
                    while ($processed = $processed_result->fetch_assoc()) {
                        $processed_id = $processed['Processed_Batch_ID'];
                        
                        // Step 3: Get all package IDs for this processed batch
                        $package_query = "SELECT Package_ID FROM package WHERE Processed_Batch_ID = ?";
                        $stmt = $conn->prepare($package_query);
                        $stmt->bind_param("i", $processed_id);
                        $stmt->execute();
                        $package_result = $stmt->get_result();

                        if ($package_result && $package_result->num_rows > 0) {
                            while ($package = $package_result->fetch_assoc()) {
                                $package_id = $package['Package_ID'];
                                
                                // Step 3a: First delete from transport_package
                                $delete_transport_package = "DELETE FROM transport_package WHERE Package_ID = ?";
                                $stmt = $conn->prepare($delete_transport_package);
                                $stmt->bind_param("i", $package_id);
                                $stmt->execute();
                            }
                        }
                        
                        // Step 4: Now delete from package
                        $delete_packages = "DELETE FROM package WHERE Processed_Batch_ID = ?";
                        $stmt = $conn->prepare($delete_packages);
                        $stmt->bind_param("i", $processed_id);
                        $stmt->execute();
                    }
                    
                    // Step 5: Delete processed_meat_batch records
                    $delete_processed = "DELETE FROM processed_meat_batch WHERE Batch_ID = ?";
                    $stmt = $conn->prepare($delete_processed);
                    $stmt->bind_param("i", $batch_id);
                    $stmt->execute();
                }
            }
            
            // Step 6: Delete meat_batch records
            $delete_batches = "DELETE FROM meat_batch WHERE Grade_ID = ?";
            $stmt = $conn->prepare($delete_batches);
            $stmt->bind_param("i", $grade_id);
            $stmt->execute();
        }
        
        // Step 7: Finally delete the grade record
        $delete_grade = "DELETE FROM meat_product_grade WHERE Grade_ID = ?";
        $stmt = $conn->prepare($delete_grade);
        $stmt->bind_param("i", $grade_id);
        
        if ($stmt->execute()) {
            // Commit the transaction if successful
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Grade and all related records deleted successfully']);
        } else {
            throw new Exception("Failed to delete grade");
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