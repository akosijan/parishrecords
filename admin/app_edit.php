<?php
include 'db_connect.php'; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $routing_number = trim($_POST['routing_number']);
    $full_name = trim($_POST['full_name']);
    $particular = trim($_POST['particular']);
    $date_received = trim($_POST['date_received']); // Added Date Received
    $date_time_released_from_cenro = trim($_POST['date_time_released_from_cenro']);
    $date_time_released_from = trim($_POST['date_time_released_from']);
    $responsible_person = trim($_POST['responsible_person']);
    $remarks = trim($_POST['remarks']);
    $sections = trim($_POST['sections']);
    $acted_date = trim($_POST['acted_date']); // Added Acted Date

    // Check if routing number already exists for another record
    $checkQuery = "SELECT id FROM cenro_release_info WHERE routing_number = ? AND id != ?";
    $stmt = $conn->prepare($checkQuery);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("si", $routing_number, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Routing Number already exists!"]);
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Corrected SQL query - removed the extra comma and added acted_date
    $updateQuery = "UPDATE cenro_release_info SET 
                        routing_number = ?, 
                        full_name = ?, 
                        particular = ?, 
                        date_received = ?,
                        date_time_released_from_cenro = ?, 
                        date_time_released_from = ?, 
                        responsible_person = ?, 
                        remarks = ?, 
                        sections = ?, 
                        acted_date = ?
                    WHERE id = ?";

    $stmt = $conn->prepare($updateQuery);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("ssssssssssi", $routing_number, $full_name, $particular, $date_received, $date_time_released_from_cenro, $date_time_released_from, $responsible_person, $remarks, $sections, $acted_date, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating record."]);
    }

    $stmt->close();
    $conn->close();
}
?>
