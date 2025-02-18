<?php
include 'db_connect.php'; // Ensure you have a database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_of_request = $_POST['date_of_request'];
    $div_sec_unit_served = $_POST['div_sec_unit_served'];
    $request_description = $_POST['request_description'];
    $date_finished = !empty($_POST['date_finished']) ? $_POST['date_finished'] : NULL;
    $rating = !empty($_POST['rating']) ? $_POST['rating'] : NULL;

    // Prepare SQL statement to prevent SQL injection
    $sql = "INSERT INTO transmittalform (date_of_request, div_sec_unit_served, request_description, date_finished, rating) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $date_of_request, $div_sec_unit_served, $request_description, $date_finished, $rating);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
