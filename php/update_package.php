<?php
require 'db_connect.php';

// Gather POST data
$package_id = $_POST['package_id'];
$product_name = $_POST['product_name'];
$package_type = $_POST['package_type'];
$weight = $_POST['weight'];
$date_packaged = $_POST['date_packaged'];
$zip = $_POST['zip'];
$quality = $_POST['quality'];

try {
    $conn->begin_transaction();

    // Update package table
    $stmt1 = $conn->prepare("UPDATE package 
                             SET Package_Type = ?, Weight = ?, Date_Packaged = ?, ZIP = ? 
                             WHERE Package_ID = ?");
    $stmt1->bind_param("sdsii", $package_type, $weight, $date_packaged, $zip, $package_id);
    $stmt1->execute();

    // Get related Processed_Batch_ID
    $stmt2 = $conn->prepare("SELECT Processed_Batch_ID FROM package WHERE Package_ID = ?");
    $stmt2->bind_param("i", $package_id);
    $stmt2->execute();
    $stmt2->bind_result($processed_batch_id);
    $stmt2->fetch();
    $stmt2->close();

    // Update processed_meat_batch table
    $stmt3 = $conn->prepare("UPDATE processed_meat_batch SET Quality = ? WHERE Processed_Batch_ID = ?");
    $stmt3->bind_param("si", $quality, $processed_batch_id);
    $stmt3->execute();

    // Get linked Product_Type_ID
    $stmt4 = $conn->prepare("
        SELECT t.Product_Type_ID
        FROM meat_product_type t
        JOIN meat_product_grade g ON t.Product_Type_ID = g.Product_Type_ID
        JOIN meat_batch b ON g.Grade_ID = b.Grade_ID
        JOIN processed_meat_batch p ON p.Batch_ID = b.Batch_ID
        WHERE p.Processed_Batch_ID = ?
        LIMIT 1
    ");
    $stmt4->bind_param("i", $processed_batch_id);
    $stmt4->execute();
    $stmt4->bind_result($product_type_id);
    $stmt4->fetch();
    $stmt4->close();

    // Update meat_product_type name
    if ($product_type_id) {
        $stmt5 = $conn->prepare("UPDATE meat_product_type SET Name = ? WHERE Product_Type_ID = ?");
        $stmt5->bind_param("si", $product_name, $product_type_id);
        $stmt5->execute();
    }

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
