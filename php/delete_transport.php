<?php
include "db_connect.php";

$transportId = $_GET['id'];

// First delete associated sensor data and devices
$conn->begin_transaction();

try {
    // Delete sensor data
    $stmt = $conn->prepare("DELETE sdata FROM sensor_data sdata
                           JOIN sensor_device sd ON sdata.Sensor_ID = sd.Sensor_ID
                           WHERE sd.Transport_ID = ?");
    $stmt->bind_param("i", $transportId);
    $stmt->execute();
    
    // Delete sensor devices
    $stmt = $conn->prepare("DELETE FROM sensor_device WHERE Transport_ID = ?");
    $stmt->bind_param("i", $transportId);
    $stmt->execute();
    
    // Finally delete the transport
    $stmt = $conn->prepare("DELETE FROM transport WHERE Transport_ID = ?");
    $stmt->bind_param("i", $transportId);
    $stmt->execute();
    
    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>