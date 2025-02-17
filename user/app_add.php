<?php
// Ensure the form data is coming via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the POST request
    $routing_number = $_POST['routing_number'];
    $full_name = $_POST['full_name'];
    $particular = $_POST['particular'];
    $date_received = $_POST['date_received']; // Added Date Received
    $date_time_released_from_cenro = $_POST['date_time_released_from_cenro'];
    $date_time_released_from = $_POST['date_time_released_from'];
    $responsible_person = $_POST['responsible_person'];
    $remarks = $_POST['remarks'];
    $sections = $_POST['sections'];
    $acted_date = $_POST['acted_date']; // Added Acted Date

    // Database connection
    include 'db_connect.php';

    // Check if routing number already exists
    $checkQuery = "SELECT * FROM cenro_release_info WHERE routing_number = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $routing_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Routing number already exists
        echo json_encode(["success" => false, "message" => "Routing Number already exists!"]);
        exit();
    }

    // Insert the data into the database
    $sql = "INSERT INTO cenro_release_info (routing_number, full_name, particular, date_received, date_time_released_from_cenro, date_time_released_from, responsible_person, remarks, sections, acted_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $routing_number, $full_name, $particular, $date_received, $date_time_released_from_cenro, $date_time_released_from, $responsible_person, $remarks, $sections, $acted_date);

    if ($stmt->execute()) {
        // Send success response
        echo json_encode(["success" => true]);
    } else {
        // Send error response
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }

    // Close the connection
    $conn->close();
}
?>
