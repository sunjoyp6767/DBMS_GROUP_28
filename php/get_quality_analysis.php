<?php
include "db_connect.php";

// Get health issues vs quality
$healthQuery = "SELECT ch.health_issue, ch.treatment_type, AVG(CASE WHEN p.quality = 'High' THEN 3 
                WHEN p.quality = 'Medium' THEN 2 ELSE 1 END) as avg_quality
                FROM cattle_health ch
                LEFT JOIN cattle c ON ch.cattle_id = c.cattle_id
                LEFT JOIN meat_batch b ON c.cattle_id = b.batch_id
                LEFT JOIN processed_meat_batch p ON b.batch_id = p.batch_id
                GROUP BY ch.health_issue, ch.treatment_type";
$healthResult = $conn->query($healthQuery);

$healthData = [];
while ($row = $healthResult->fetch_assoc()) {
    $healthData[] = $row;
}

// Get problem facilities
$facilityQuery = "SELECT name, health_inspection_report, processing_time 
                  FROM slaughtering_house 
                  WHERE health_inspection_report = 'Failed' 
                  OR processing_time > '08:00:00'";
$facilityResult = $conn->query($facilityQuery);

$facilityData = [];
while ($row = $facilityResult->fetch_assoc()) {
    $facilityData[] = $row;
}

$response = [
    'healthIssues' => $healthData,
    'problemFacilities' => $facilityData
];

header('Content-Type: application/json');
echo json_encode($response);
?>