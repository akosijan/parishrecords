<?php
include 'db_connect.php'; // Ensure you have a database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = $_POST['project_name'];
    $particular = $_POST['particular'];
    $amount_remarks = $_POST['amount_remarks'];
    $date = $_POST['date'];
  

    // Prepare SQL statement to prevent SQL injection
    $sql = "INSERT INTO transmit_docs (project_name, particular, amount_remarks, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $project_name, $particular, $amount_remarks, $date);

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
