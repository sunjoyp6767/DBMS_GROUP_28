<?php
require_once __DIR__ . '/../../php/db_connect.php';

try {
    // Add default option
    echo "<option value=''>Select Product Type</option>";
    
    $query = "SELECT Product_Type_ID, Name, Description FROM meat_product_type ORDER BY Name";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        while ($type = $result->fetch_assoc()) {
            echo "<option value='" . $type['Product_Type_ID'] . "'>" . 
                 "ID: " . $type['Product_Type_ID'] . " - " . 
                 htmlspecialchars($type['Name']) . 
                 "</option>";
        }
    } else {
        echo "<option value='' disabled>No product types available</option>";
    }
} catch(Exception $e) {
    echo "<option value='' disabled>Error loading product types</option>";
}
?> 