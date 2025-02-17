<?php
include 'db_connect.php'; // Ensure database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $routing_number = $_POST['routing_number'];
    $full_name = $_POST['full_name'];
    $particular = $_POST['particular'];
    $date_time_released_from_cenro = $_POST['date_time_released_from_cenro'];
    $date_time_released_from = $_POST['date_time_released_from'];
    $responsible_person = $_POST['responsible_person'];
    $sections = $_POST['sections'];
    $remarks = $_POST['remarks'];

    // Prepare and execute update query
    $query = "UPDATE cenro_release_info SET routing_number = ?, full_name = ?, particular = ?, date_time_released_from_cenro = ?, date_time_released_from = ?, responsible_person = ?, sections = ?, remarks = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssssi", $routing_number, $full_name, $particular, $date_time_released_from_cenro, $date_time_released_from, $responsible_person, $sections, $remarks, $id);

    if ($stmt->execute()) {
        header("Location: app_entry.php?success=1");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
