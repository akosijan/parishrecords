<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Check if serial number already exists
    $check_query = "SELECT * FROM icte_inventory WHERE serial_number = '$serial_number'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If serial number exists, show SweetAlert and prevent insertion
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Serial Number!',
                    text: 'The serial number you entered is already in the system.',
                    confirmButtonText: 'OK'
                }).then(function() {
                    // Redirect after the alert is closed
                    window.location.href = 'inventory.php';
                });
              </script>";
    } else {
        // Proceed with insertion if no duplicate serial number
        $query = "INSERT INTO icte_inventory (user, item_no, serial_number, article_item, description, property_no, unit_value, acquisition_date, person_accountable, office, remarks, ageing_years, ageing_months, ageing_years_months) 
                  VALUES ('$user', '$item_no', '$serial_number', '$article_item', '$description', '$property_no', '$unit_value', '$acquisition_date', '$person_accountable', '$office', '$remarks', '$ageing_years', '$ageing_months', '$ageing_years_months')";

        if (mysqli_query($conn, $query)) {
            header("Location: inventory.php"); // Redirect on successful insertion
            exit(); // Ensure the script stops executing after the redirect
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>