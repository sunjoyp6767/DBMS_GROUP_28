<?php
require_once __DIR__ . '/../db_connect.php';

try {
    $query = "SELECT Product_Type_ID, Name FROM meat_product_type ORDER BY Product_Type_ID";
    $result = $conn->query($query);

    if ($result) {
        while ($type = $result->fetch_assoc()) {
            echo "<option value='" . $type['Product_Type_ID'] . "'>" . 
                 "ID: " . $type['Product_Type_ID'] . " - " . 
                 htmlspecialchars($type['Name']) . 
                 "</option>";
        }
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 