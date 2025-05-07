<?php
require_once __DIR__ . '/../../php/db_connect.php';

try {
    $query = "
        SELECT 
            g.Grade_ID,
            g.Description,
            g.Quality_Score,
            g.Average_Weight,
            g.Texture_Quality,
            g.Date_of_Grading,
            p.Name as Product_Type_Name,
            p.Product_Type_ID,
            p.Description as Product_Description
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
            
            // Define unique colors for each product type
            $productTypeColors = [
                'beef' => 'badge-beef',
                'pork' => 'badge-pork',
                'chicken' => 'badge-chicken',
                'lamb' => 'badge-lamb',
                'turkey' => 'badge-turkey',
                'duck' => 'badge-duck'
            ];
            
            // Get the color class for the product type, default to primary if not found
            $productTypeColor = $productTypeColors[$productType] ?? 'badge-primary';
            
            // Format the date
            $formattedDate = date('Y-m-d', strtotime($grade['Date_of_Grading']));
            
            echo "<tr>";
            // Grade ID
            echo "<td>" . $grade['Grade_ID'] . "</td>";
            
            // Product Type with ID and badge
            echo "<td><span class='table-badge {$productTypeColor}'>" . 
                 "ID: " . $grade['Product_Type_ID'] . " - " . 
                 htmlspecialchars($grade['Product_Type_Name']) . "</span></td>";
            
            // Description
            echo "<td>" . htmlspecialchars($grade['Description']) . "</td>";
            
            // Quality Score with color coding
            echo "<td class='quality-score {$qualityClass}'>" . 
                 number_format($grade['Quality_Score'], 2) . "</td>";
            
            // Average Weight with unit
            echo "<td>" . number_format($grade['Average_Weight'], 2) . " kg</td>";
            
            // Texture Quality with badge
            echo "<td><span class='table-badge badge-{$textureType}'>" . 
                 htmlspecialchars($grade['Texture_Quality']) . "</span></td>";
            
            // Date of Grading
            echo "<td>" . $formattedDate . "</td>";
            
            // Action Buttons
            echo "<td>";
            echo "<div class='action-buttons'>";
            // Edit button with data attributes
            echo "<button class='btn btn-primary btn-sm edit-btn' 
                    data-grade-id='" . $grade['Grade_ID'] . "'
                    data-description='" . htmlspecialchars($grade['Description']) . "'
                    data-quality-score='" . $grade['Quality_Score'] . "'
                    data-average-weight='" . $grade['Average_Weight'] . "'
                    data-texture-quality='" . htmlspecialchars($grade['Texture_Quality']) . "'
                    data-date-of-grading='" . $formattedDate . "'
                    data-product-type-id='" . $grade['Product_Type_ID'] . "'
                    title='Edit'>
                    <i class='fas fa-edit'></i>
                  </button>";
            // Delete button
            echo "<button class='btn btn-danger btn-sm delete-btn' 
                    data-grade-id='" . $grade['Grade_ID'] . "'
                    title='Delete'>
                    <i class='fas fa-trash'></i>
                  </button>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>No grades found</td></tr>";
    }
} catch(Exception $e) {
    echo "<tr><td colspan='8' class='text-center text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
}
?> 