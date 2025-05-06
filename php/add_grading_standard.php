<?php
include "db_connect.php";

// Get product type ID first
$productType = $_POST['Product_Type'];
$stmt = $conn->prepare("SELECT Product_Type_ID FROM meat_product_type WHERE Name = ?");
$stmt->bind_param("s", $productType);
$stmt->execute();
$result = $stmt->get_result();
$productTypeId = $result->fetch_assoc()['Product_Type_ID'];

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
    echo json_encode(['success' => true, 'Grade_ID' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>