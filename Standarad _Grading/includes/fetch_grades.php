<?php
require_once __DIR__ . '/../db_connect.php';

try {
    $query = "
        SELECT g.*, p.Name as Product_Type_Name, p.Product_Type_ID 
        FROM meat_product_grade g
        JOIN meat_product_type p ON g.Product_Type_ID = p.Product_Type_ID
        ORDER BY g.Grade_ID DESC
    ";
    $result = $conn->query($query);

    if ($result) {
        while ($grade = $result->fetch_assoc()) {
            // Determine quality class based on score
            $qualityClass = '';
            $score = floatval($grade['Quality_Score']);
            if ($score >= 8.5) {
                $qualityClass = 'quality-high';
            } elseif ($score >= 7) {
                $qualityClass = 'quality-medium';
            } else {
                $qualityClass = 'quality-low';
            }
            
            // Get product type in lowercase for badge styling
            $productType = strtolower($grade['Product_Type_Name']);
            $textureType = strtolower($grade['Texture_Quality']);
            
            echo "<tr>";
            echo "<td>GRD" . str_pad($grade['Grade_ID'], 3, '0', STR_PAD_LEFT) . "</td>";
            echo "<td><span class='table-badge badge-{$productType}'>" . htmlspecialchars($grade['Product_Type_Name']) . "</span></td>";
            echo "<td>" . htmlspecialchars($grade['Description']) . "</td>";
            echo "<td class='quality-score {$qualityClass}'>" . number_format($grade['Quality_Score'], 2) . "</td>";
            echo "<td>" . number_format($grade['Average_Weight'], 2) . " kg</td>";
            echo "<td><span class='table-badge badge-{$textureType}'>" . htmlspecialchars($grade['Texture_Quality']) . "</span></td>";
            echo "<td>" . date('Y-m-d', strtotime($grade['Date_of_Grading'])) . "</td>";
            echo "<td>";
            echo "<div class='action-buttons'>";
            echo "<button class='btn btn-primary btn-sm edit-btn' data-grade-id='" . $grade['Grade_ID'] . "' title='Edit'>
                    <i class='fas fa-edit'></i>
                  </button>";
            echo "<button class='btn btn-danger btn-sm delete-btn' data-grade-id='" . $grade['Grade_ID'] . "' title='Delete'>
                    <i class='fas fa-trash'></i>
                  </button>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 