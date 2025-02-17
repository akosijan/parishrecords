<?php
// app_delete.php

include 'db_connect.php'; // Assuming this is where you handle DB connection

// Check if the 'id' is set in the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare the SQL statement to delete the record
    $sql = "DELETE FROM cenro_release_info WHERE id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the 'id' parameter
        $stmt->bind_param("i", $id);

        // Execute the statement
        if ($stmt->execute()) {
            // If deletion is successful, send a success response
            echo json_encode(['success' => true, 'message' => 'Record deleted successfully.']);
        } else {
            // If deletion fails, send a failure response
            echo json_encode(['success' => false, 'message' => 'Error deleting record.']);
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // If SQL prepare fails, return an error
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL query.']);
    }
} else {
    // If no 'id' is provided in the POST request, return an error
    echo json_encode(['success' => false, 'message' => 'No ID provided.']);
}

// Close the database connection
$conn->close();
?>
