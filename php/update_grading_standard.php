<?php
include "db_connect.php";

// Get form data
$grade_id = $_POST['grade_id'];
$description = $_POST['description'];
$quality_score = $_POST['quality_score'];
$average_weight = $_POST['average_weight'];
$texture = $_POST['texture'];
$grading_date = $_POST['grading_date'];
$quantity = $_POST['quantity'];

// Update grading standard
$stmt = $conn->prepare("UPDATE meat_product_grade 
                       SET Description = ?, Quality_Score = ?, Average_Weight = ?, 
                           Texture_Quality = ?, Date_of_Grading = ?
                       WHERE Grade_ID = ?");
$stmt->bind_param("ssdssi", $description, $quality_score, $average_weight, $texture, $grading_date, $grade_id);

if ($stmt->execute()) {
    // Update the associated batch quantity
    $batchStmt = $conn->prepare("UPDATE meat_batch SET Quantity = ? WHERE Grade_ID = ?");
    $batchStmt->bind_param("ii", $quantity, $grade_id);
    
    if ($batchStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update batch: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$conn->close();
?>