<?php
include "db_connect.php";

$id = $_GET['id'];

// Start transaction
$conn->begin_transaction();

try {
    // First delete the associated meat batch
    $stmt = $conn->prepare("DELETE FROM meat_batch WHERE Grade_ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Then delete the grading standard
    $stmt = $conn->prepare("DELETE FROM meat_product_grade WHERE Grade_ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>