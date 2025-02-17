<?php
include 'db_connect.php'; // Ensure the database connection is included

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id']) && isset($_POST['column'])) {
        $id = $_POST['id'];
        $column = $_POST['column']; // Column to be deleted

        // Define the allowed columns to prevent arbitrary deletions
        $allowed_columns = ['id', 'routing_number', 'full_name', 'particular', 'date_time_released_from_cenro', 'date_time_released_from', 'responsible_person', 'sections', 'remarks'];

        if (!in_array($column, $allowed_columns)) {
            echo json_encode(["success" => false, "message" => "Invalid column specified"]);
            exit;
        }

        // Prepare SQL query to delete the record
        $query = "DELETE FROM cenro_release_info WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Record deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Database error"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid method"]);
}

$conn->close();
