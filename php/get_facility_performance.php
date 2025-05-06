<?php
include "db_connect.php";

// Get facility performance data
$query = "SELECT 
            name,
            TIME_TO_SEC(processing_time)/3600 as processing_hours,
            CASE 
              WHEN health_inspection_report = 'Failed' THEN '#F44336'
              WHEN TIME_TO_SEC(processing_time) > 28800 THEN '#FFC107'  # More than 8 hours
              ELSE '#4CAF50'
            END as color
          FROM slaughtering_house
          ORDER BY processing_hours DESC";

$result = $conn->query($query);

$labels = [];
$processingTimes = [];
$colors = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['name'];
    $processingTimes[] = $row['processing_hours'];
    $colors[] = $row['color'];
}

$response = [
    'labels' => $labels,
    'processingTimes' => $processingTimes,
    'colors' => $colors
];

header('Content-Type: application/json');
echo json_encode($response);
?>