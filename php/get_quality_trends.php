<?php
include "db_connect.php";

// Get quality trends data by month
$query = "SELECT 
            DATE_FORMAT(p.date_processed, '%b') as month,
            SUM(CASE WHEN p.quality = 'High' THEN 1 ELSE 0 END) as high,
            SUM(CASE WHEN p.quality = 'Medium' THEN 1 ELSE 0 END) as medium,
            SUM(CASE WHEN p.quality = 'Low' THEN 1 ELSE 0 END) as low
          FROM processed_meat_batch p
          GROUP BY DATE_FORMAT(p.date_processed, '%m'), DATE_FORMAT(p.date_processed, '%b')
          ORDER BY DATE_FORMAT(p.date_processed, '%m')";

$result = $conn->query($query);

$labels = [];
$high = [];
$medium = [];
$low = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['month'];
    $high[] = $row['high'];
    $medium[] = $row['medium'];
    $low[] = $row['low'];
}

$response = [
    'labels' => $labels,
    'high' => $high,
    'medium' => $medium,
    'low' => $low
];

header('Content-Type: application/json');
echo json_encode($response);
?>