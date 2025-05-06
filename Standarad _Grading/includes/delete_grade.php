<?php
require_once __DIR__ . '/../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grade_id'])) {
    try {
        // Start transaction to ensure all operations are completed or none
        $conn->begin_transaction();
        
        $grade_id = intval($_POST['grade_id']);
        
        // Step 1: Get all batch IDs related to this grade
        $batch_query = "SELECT Batch_ID FROM meat_batch WHERE Grade_ID = $grade_id";
        $batch_result = $conn->query($batch_query);
        
        if ($batch_result && $batch_result->num_rows > 0) {
            while ($batch = $batch_result->fetch_assoc()) {
                $batch_id = $batch['Batch_ID'];
                
                // Step 2: Get all processed batch IDs related to this batch
                $processed_query = "SELECT Processed_Batch_ID FROM processed_meat_batch WHERE Batch_ID = $batch_id";
                $processed_result = $conn->query($processed_query);
                
                if ($processed_result && $processed_result->num_rows > 0) {
                    while ($processed = $processed_result->fetch_assoc()) {
                        $processed_id = $processed['Processed_Batch_ID'];
                        
                        // Step 3: Get all package IDs for this processed batch
                        $package_query = "SELECT Package_ID FROM package WHERE Processed_Batch_ID = $processed_id";
                        $package_result = $conn->query($package_query);
                        
                        if ($package_result && $package_result->num_rows > 0) {
                            while ($package = $package_result->fetch_assoc()) {
                                $package_id = $package['Package_ID'];
                                
                                // Step 3a: First delete from transport_package
                                $delete_transport_package = "DELETE FROM transport_package WHERE Package_ID = $package_id";
                                $conn->query($delete_transport_package);
                            }
                        }
                        
                        // Step 4: Now delete from package
                        $delete_packages = "DELETE FROM package WHERE Processed_Batch_ID = $processed_id";
                        $conn->query($delete_packages);
                    }
                    
                    // Step 5: Delete processed_meat_batch records
                    $delete_processed = "DELETE FROM processed_meat_batch WHERE Batch_ID = $batch_id";
                    $conn->query($delete_processed);
                }
            }
            
            // Step 6: Delete meat_batch records
            $delete_batches = "DELETE FROM meat_batch WHERE Grade_ID = $grade_id";
            $conn->query($delete_batches);
        }
        
        // Step 7: Finally delete the grade record
        $delete_grade = "DELETE FROM meat_product_grade WHERE Grade_ID = $grade_id";
        
        if ($conn->query($delete_grade)) {
            // Commit the transaction if successful
            $conn->commit();
            echo json_encode(['success' => true]);
        } else {
            throw new Exception($conn->error);
        }
    } catch(Exception $e) {
        // Roll back the transaction if any error occurred
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?> 