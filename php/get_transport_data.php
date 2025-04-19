<?php
include "db_connect.php";

$query = "SELECT 
            t.Transport_ID, 
            t.Vehicle_Type, 
            t.License_Plate, 
            t.Transport_Date, 
            t.Transportation_Duration,
            sd.Sensor_Type,
            sdata.Temperature, 
            sdata.Humidity, 
            sdata.Latitude, 
            sdata.Longitude,
            sdata.Timestamp
          FROM transport t
          LEFT JOIN sensor_device sd ON t.Transport_ID = sd.Transport_ID
          LEFT JOIN (
              SELECT Sensor_ID, MAX(Timestamp) as latest_time
              FROM sensor_data
              GROUP BY Sensor_ID
          ) latest ON sd.Sensor_ID = latest.Sensor_ID
          LEFT JOIN sensor_data sdata ON sdata.Sensor_ID = latest.Sensor_ID AND sdata.Timestamp = latest.latest_time
          ORDER BY t.Transport_ID";
          
$result = $conn->query($query);

if (!$result) {
    // Handle query error
    die("Query failed: " . $conn->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'transport_id' => $row['Transport_ID'],
        'vehicle_type' => $row['Vehicle_Type'],
        'license_plate' => $row['License_Plate'],
        'transport_date' => $row['Transport_Date'],
        'transportation_duration' => $row['Transportation_Duration'],
        'temperature' => $row['Temperature'] ?? null,
        'humidity' => $row['Humidity'] ?? null,
        'latitude' => $row['Latitude'] ?? null,
        'longitude' => $row['Longitude'] ?? null,
        'sensor_type' => $row['Sensor_Type'] ?? 'N/A',
        'timestamp' => $row['Timestamp'] ?? null
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>