<?php
include 'db_connect.php'; // Ensure this file contains the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Query to get data based on ID
    $query = "SELECT * FROM icte_inventory WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row); // Return the data as a JSON object
    } else {
        echo json_encode(['error' => 'No data found']);
    }
}
?>
