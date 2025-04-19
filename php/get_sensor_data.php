<?php
require_once 'db_connect.php';

$sql = "
  SELECT sd.Sensor_ID, sd.Temperature, sd.Humidity, sd.Latitude, sd.Longitude, sd.Timestamp,
         t.Vehicle_Type, t.License_Plate, t.Transport_ID,
         rs.Name AS destination, rs.Latitude AS dest_lat, rs.Longitude AS dest_lng
  FROM sensor_data sd
  JOIN sensor_device d ON sd.Sensor_ID = d.Sensor_ID
  JOIN transport t ON d.Transport_ID = t.Transport_ID
  JOIN retail_store rs ON t.Destination LIKE CONCAT(rs.Name, '%')
  ORDER BY sd.Timestamp DESC
";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed', 'details' => $conn->error]);
    exit;
}

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'sensor_id'     => $row['Sensor_ID'],
        'temperature'   => $row['Temperature'],
        'humidity'      => $row['Humidity'],
        'latitude'      => $row['Latitude'],
        'longitude'     => $row['Longitude'],
        'timestamp'     => $row['Timestamp'],
        'vehicle_type'  => $row['Vehicle_Type'],
        'license_plate' => $row['License_Plate'],
        'transport_id'  => $row['Transport_ID'],
        'destination'   => $row['destination'],
        'dest_lat'      => $row['dest_lat'],
        'dest_lng'      => $row['dest_lng']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
