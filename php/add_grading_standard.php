<?php
include "db_connect.php";

// Get product type ID first
$productType = $_POST['Product_Type'];
$stmt = $conn->prepare("SELECT Product_Type_ID FROM meat_product_type WHERE Name = ?");
$stmt->bind_param("s", $productType);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product type not found']);
    exit();
}

$row = $result->fetch_assoc();
$productTypeId = $row['Product_Type_ID'];

// Insert grading standard
$stmt = $conn->prepare("INSERT INTO meat_product_grade 
                       (Product_Type_ID, Description, Quality_Score, Average_Weight, 
                        Texture_Quality, Date_of_Grading, Inspector_Name, Inspection_Notes) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssss", 
    $productTypeId, 
    $_POST['Description'], 
    $_POST['Quality_Score'], 
    $_POST['Average_Weight'], 
    $_POST['Texture_Quality'], 
    $_POST['Date_of_Grading'],
    $_POST['Inspector_Name'],
    $_POST['Inspection_Notes']
);

if ($stmt->execute()) {
    $gradeId = $stmt->insert_id;
    
    // Now create the meat batch record
    $batchStmt = $conn->prepare("INSERT INTO meat_batch 
                                (Date_Processed, Quantity, Grade_ID, Cattle_ID, Weight) 
                                VALUES (?, ?, ?, ?, ?)");
    $batchStmt->bind_param("siiid",
        $_POST['Date_of_Grading'],
        $_POST['Quantity'],
        $gradeId,
        $_POST['Cattle_ID'],
        $_POST['Average_Weight']
    );
    
    if ($batchStmt->execute()) {
        echo json_encode(['success' => true, 'Grade_ID' => $gradeId]);
    } else {
        // Roll back the grading standard if batch creation fails
        $conn->query("DELETE FROM meat_product_grade WHERE Grade_ID = $gradeId");
        echo json_encode(['success' => false, 'message' => 'Failed to create batch: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$conn->close();
?>