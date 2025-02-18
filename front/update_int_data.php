<?php
include 'db_connect.php'; // Ensure this file contains the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the AJAX request
    $id = $_POST['id'];
    $user = $_POST['user'];
    $item_no = $_POST['item_no'];
    $serial_number = $_POST['serial_number'];
    $article_item = $_POST['article_item'];
    $description = $_POST['description'];
    $property_no = $_POST['property_no'];
    $unit_value = $_POST['unit_value'];
    $acquisition_date = $_POST['acquisition_date'];
    $person_accountable = $_POST['person_accountable'];
    $office = $_POST['office'];
    $remarks = $_POST['remarks'];
    $ageing_years = $_POST['ageing_years'];
    $ageing_months = $_POST['ageing_months'];
    $ageing_years_months = $_POST['ageing_years_months'];

    // Prepare the SQL query to update the data
    $query = "UPDATE icte_inventory SET 
                user = '$user', 
                item_no = '$item_no', 
                serial_number = '$serial_number', 
                article_item = '$article_item', 
                description = '$description', 
                property_no = '$property_no', 
                unit_value = '$unit_value', 
                acquisition_date = '$acquisition_date', 
                person_accountable = '$person_accountable', 
                office = '$office', 
                remarks = '$remarks', 
                ageing_years = '$ageing_years', 
                ageing_months = '$ageing_months', 
                ageing_years_months = '$ageing_years_months' 
                WHERE id = '$id'";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
