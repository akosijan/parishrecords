<?php
include 'db_connect.php'; // Ensure database connection is included

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize the input

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM icte_inventory WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'success'; // Send success response
    } else {
        echo 'error'; // Send error response
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'invalid'; // Invalid request
}
?>
