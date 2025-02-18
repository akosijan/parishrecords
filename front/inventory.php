<?php
include 'header.php';
include 'db_connect.php'; // Ensure this file contains the database connection
?>

<!-- Add this in your HTML <style> section or in your CSS file -->
<style>
    /* Prevent breaking the serial number across multiple lines */
    .serial-number {
        white-space: nowrap;
    }

    /* Adjust the modal size */
    .modal-dialog {
        max-width: 600px;
        width: 100%;
    }

    .modal-body {
        max-height: 10000vh;
        overflow-y: auto;
    }

    /* Table responsiveness */
    #inventoryTable_wrapper {
        overflow-x: auto;
    }

    /* Set a fixed height for the table and make it scrollable */
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
    }

    .dataTables_wrapper .dataTables_scrollBody {
        overflow: auto !important;
    }
</style>

<body class="hold-transition layout-fixed">
    <div class="wrapper">

        <?php include 'navbar.php'; ?>

        <!-- content -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <button class="btn btn-success" data-toggle="modal" data-target="#addDataModal">Add Data</button>
                                <a href="export_pdf.php" class="btn btn-danger">Export PDF</a>
                            </div>
                            <h3 class="card-title">Inventory Data</h3>
                        </div>
                        <div class="card-body">
                            <table id="inventoryTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Item No.</th>
                                        <th>Serial No.</th>
                                        <th>Article/Item</th>
                                        <th>Description</th>
                                        <th>Property No.</th>
                                        <th>Unit Value</th>
                                        <th>Acquisition Date</th>
                                        <th>Person Accountable</th>
                                        <th>Office</th>
                                        <th>Remarks</th>
                                        <th>Ageing/ Shelf Life Inventory (YEARS)</th>
                                        <th>Ageing/ Shelf Life Inventory (MONTHS)</th>
                                        <th>Ageing/ Shelf Life Inventory (YEARS & MONTH)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM icte_inventory";
                                    $result = mysqli_query($conn, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                            <td>{$row['user']}</td>
                                            <td>{$row['item_no']}</td>
                                            <td class='serial-number'>{$row['serial_number']}</td> <!-- Added class here -->
                                            <td>{$row['article_item']}</td>
                                            <td>{$row['description']}</td>
                                            <td>{$row['property_no']}</td>
                                            <td>{$row['unit_value']}</td>
                                            <td>{$row['acquisition_date']}</td>
                                            <td>{$row['person_accountable']}</td>
                                            <td>{$row['office']}</td>
                                            <td>{$row['remarks']}</td>
                                            <td>{$row['ageing_years']}</td>
                                            <td>{$row['ageing_months']}</td>
                                            <td>{$row['ageing_years_months']}</td>
                                            <td>
                                                <div class='d-flex flex-column align-items-center'>
                                                    <button class='btn btn-primary btn-sm mb-1 editBtn' data-id='{$row['id']}'>Edit</button>

                                                    <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['id']}'>Delete</button>
                                                </div>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- end content -->
    </div>
<!-- Edit Data Modal -->
<div class="modal fade" id="editDataModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="update_int_data.php" method="POST" id="editForm">
                    <input type="hidden" name="id" id="editId">
                    <div class="form-group">
                        <label>User</label>
                        <input type="text" class="form-control" name="user" id="editUser" required>
                    </div>
                    <div class="form-group">
                        <label>Item No.</label>
                        <input type="text" class="form-control" name="item_no" id="editItemNo" required>
                    </div>
                    <div class="form-group">
                        <label>Serial No.</label>
                        <input type="text" class="form-control" name="serial_number" id="editSerialNumber" required>
                    </div>
                    <div class="form-group">
                        <label>Article/Item</label>
                        <input type="text" class="form-control" name="article_item" id="editArticleItem" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" id="editDescription" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Property No.</label>
                        <input type="text" class="form-control" name="property_no" id="editPropertyNo" required>
                    </div>
                    <div class="form-group">
                        <label>Unit Value</label>
                        <input type="number" class="form-control" name="unit_value" id="editUnitValue" required>
                    </div>
                    <div class="form-group">
                        <label>Acquisition Date</label>
                        <input type="date" class="form-control" name="acquisition_date" id="editAcquisitionDate" required>
                    </div>
                    <div class="form-group">
                        <label>Person Accountable</label>
                        <input type="text" class="form-control" name="person_accountable" id="editPersonAccountable" required>
                    </div>
                    <div class="form-group">
                        <label>Office</label>
                        <input type="text" class="form-control" name="office" id="editOffice" required>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="editRemarks">
                    </div>
                    <div class="form-group">
                        <label>Ageing/ Shelf Life Inventory (YEARS)</label>
                        <input type="number" class="form-control" name="ageing_years" id="editAgeingYears" min="0">
                    </div>
                    <div class="form-group">
                        <label>Ageing/ Shelf Life Inventory (MONTHS)</label>
                        <input type="number" class="form-control" name="ageing_months" id="editAgeingMonths" min="0" max="11">
                    </div>
                    <div class="form-group">
                        <label>Ageing/ Shelf Life Inventory (YEARS & MONTHS)</label>
                        <input type="text" class="form-control" name="ageing_years_months" id="editAgeingYearsMonths" placeholder="e.g., 3 years 5 months">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Add Data Modal -->
    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Data</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="add_data.php" method="POST">
                        <div class="form-group">
                            <label>User</label>
                            <input type="text" class="form-control" name="user" required>
                        </div>
                        <div class="form-group">
                            <label>Item No.</label>
                            <input type="text" class="form-control" name="item_no" required>
                        </div>
                        <div class="form-group">
                            <label>Serial No.</label>
                            <input type="text" class="form-control" name="serial_number" required>
                        </div>

                        <div class="form-group">
                            <label>Article/Item</label>
                            <input type="text" class="form-control" name="article_item" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Property No.</label>
                            <input type="text" class="form-control" name="property_no" required>
                        </div>
                        <div class="form-group">
                            <label>Unit Value</label>
                            <input type="number" class="form-control" name="unit_value" required>
                        </div>
                        <div class="form-group">
                            <label>Acquisition Date</label>
                            <input type="date" class="form-control" name="acquisition_date" required>
                        </div>
                        <div class="form-group">
                            <label>Person Accountable</label>
                            <input type="text" class="form-control" name="person_accountable" required>
                        </div>
                        <div class="form-group">
                            <label>Office</label>
                            <input type="text" class="form-control" name="office" required>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <input type="text" class="form-control" name="remarks">
                        </div>
                        <div class="form-group">
                            <label>Ageing/ Shelf Life Inventory (YEARS) </label>
                            <input type="number" class="form-control" name="ageing_years" min="0">
                        </div>
                        <div class="form-group">
                            <label>Ageing/ Shelf Life Inventory (MONTHS) </label>
                            <input type="number" class="form-control" name="ageing_months" min="0" max="11">
                        </div>
                        <div class="form-group">
                            <label>Ageing/ Shelf Life Inventory (YEARS & MONTH)</label>
                            <input type="text" class="form-control" name="ageing_years_months" placeholder="e.g., 3 years 5 months">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>

<!-- DataTables Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable();

        // Delete button functionality with SweetAlert
// Delete button functionality with SweetAlert
$('.deleteBtn').click(function() {
    var id = $(this).data('id');

    // SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to delete record
            $.ajax({
                url: 'delete_int_data.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The item has been deleted.',
                            icon: 'success',
                            showConfirmButton: true, // Show the confirm button
                            confirmButtonText: 'Close', // Close button text
                        }).then(() => {
                            // Reload the page after the user clicks "Close"
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                    }
                }
            });
        }
    });
});


    });
    $(document).ready(function() {
    var existingSerialNumbers = [];
    // Populate existing serial numbers from the table (or use a database call)
    $('#inventoryTable tbody tr').each(function() {
        var serialNumber = $(this).find('.serial-number').text().trim();
        existingSerialNumbers.push(serialNumber);
    });

    // Attach a listener to the serial number input field
    $("input[name='serial_number']").on('input', function() {
        var enteredSerialNumber = $(this).val().trim();
        if (existingSerialNumbers.includes(enteredSerialNumber)) {
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Serial Number!',
                text: 'This serial number already exists in the system.',
                confirmButtonText: 'OK'
            });
        }
    });

    // DataTables initialization
    $('#inventoryTable').DataTable();
});


$(document).ready(function() {
    // When the edit button is clicked
    $('.editBtn').click(function() {
        var id = $(this).data('id'); // Get the ID of the item
        
        // Make an AJAX request to fetch the data for the specific ID
        $.ajax({
            url: 'get_inventory_data.php', // Create a new file to fetch data for the item
            type: 'POST',
            data: { id: id },
            success: function(response) {
                var data = JSON.parse(response); // Assuming the response is JSON

                // Populate the modal fields with the data
                $('#editId').val(data.id);
                $('#editUser').val(data.user);
                $('#editItemNo').val(data.item_no);
                $('#editSerialNumber').val(data.serial_number);
                $('#editArticleItem').val(data.article_item);
                $('#editDescription').val(data.description);
                $('#editPropertyNo').val(data.property_no);
                $('#editUnitValue').val(data.unit_value);
                $('#editAcquisitionDate').val(data.acquisition_date);
                $('#editPersonAccountable').val(data.person_accountable);
                $('#editOffice').val(data.office);
                $('#editRemarks').val(data.remarks);
                $('#editAgeingYears').val(data.ageing_years);
                $('#editAgeingMonths').val(data.ageing_months);
                $('#editAgeingYearsMonths').val(data.ageing_years_months);

                // Show the modal
                $('#editDataModal').modal('show');
            }
        });
    });

    // When the form is submitted (after confirmation)
    $('#editForm').submit(function(e) {
        e.preventDefault(); // Prevent form from submitting the usual way

        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to save the changes?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gather form data
                var formData = $(this).serialize();

                // Make the AJAX request to update the data
                $.ajax({
                    url: 'update_int_data.php', // The PHP script that handles updating
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire({
                                title: 'Updated!',
                                text: 'The item has been updated.',
                                icon: 'success',
                                confirmButtonText: 'Close'
                            }).then(() => {
                                // Close the modal and reload the page after successful update
                                $('#editDataModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                        }
                    }
                });
            }
        });
    });
});


</script>