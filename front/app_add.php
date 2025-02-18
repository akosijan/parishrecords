<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $routing_number = $_POST['routing_number'];
    $full_name = $_POST['full_name'];
    $particular = $_POST['particular'];
    $date_received = $_POST['date_received'];

    include 'db_connect.php';

    $checkQuery = "SELECT * FROM cenro_release_info WHERE routing_number = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $routing_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Routing Number already exists!"]);
        exit();
    }

    $sql = "INSERT INTO cenro_release_info (routing_number, full_name, particular, date_received)
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $routing_number, $full_name, $particular, $date_received);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }

    $conn->close();
}
?>
