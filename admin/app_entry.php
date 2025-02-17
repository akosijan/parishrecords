<?php
include 'header.php';
?>


<body class="hold-transition layout-fixed">
    <div class="wrapper">

        <?php
        include 'navbar.php';
        ?>


        <!-- content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="text-center">Application Entry</h1>
                </div>
            </div>

            <?php
            // Fetch records from the database (the same as above)
            $sql = "SELECT * FROM cenro_release_info";
            $result = $conn->query($sql);
            $records = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $records[] = $row;
                }
            }
            ?>

<div class="container-fluid">
    <div>
        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#staticBackdrop">Add Data</button>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table no-wrap table-striped" id="DataTables_Table_0">
                <thead>
    <tr>
        <th scope="col">Routing Number</th>
        <th scope="col">Full name</th>
        <th scope="col">Particular</th>
        <th scope="col">Date Received</th> <!-- Moved column -->
        <th scope="col">Date & Time Released from CENRO Office</th>
        <th scope="col">Date & Time Released From</th>
        <th scope="col">Responsible Person</th>
        <th scope="col">Sections</th>
        <th scope="col">Remarks</th>
        <th scope="col">Date Acted</th>   <!-- Moved column -->
        <th scope="col">Action</th>
    </tr>
</thead>
<tbody>
    <?php if (!empty($records)): ?>
        <?php foreach ($records as $record): ?>
            <tr id="record_<?php echo $record['id']; ?>">
                <th scope="row"><?php echo $record['routing_number']; ?></th>
                <td><?php echo $record['full_name']; ?></td>
                <td><?php echo $record['particular']; ?></td>
                <td><?php echo $record['date_received']; ?></td> <!-- Display Date Received here -->
                <td><?php echo $record['date_time_released_from_cenro']; ?></td>
                <td><?php echo $record['date_time_released_from']; ?></td>
                <td><?php echo $record['responsible_person']; ?></td>
                <td><?php echo $record['sections']; ?></td>
                <td><?php echo $record['remarks']; ?></td>
                <td><?php echo $record['acted_date']; ?></td> <!-- Display Date Acted here -->

                <td>
                    <button class="btn btn-warning btn-sm edit-btn"
                        data-id="<?php echo $record['id']; ?>"
                        data-routing_number="<?php echo htmlspecialchars($record['routing_number'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-full_name="<?php echo htmlspecialchars($record['full_name'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-particular="<?php echo htmlspecialchars($record['particular'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-date_time_released_from_cenro="<?php echo htmlspecialchars($record['date_time_released_from_cenro'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-date_time_released_from="<?php echo htmlspecialchars($record['date_time_released_from'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-responsible_person="<?php echo htmlspecialchars($record['responsible_person'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-sections="<?php echo htmlspecialchars($record['sections'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-remarks="<?php echo htmlspecialchars($record['remarks'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-date_received="<?php echo htmlspecialchars($record['date_received'], ENT_QUOTES, 'UTF-8'); ?>"  
                        data-acted_date="<?php echo htmlspecialchars($record['acted_date'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-toggle="modal" data-target="#editModal">
                        Edit
                    </button>

                    <button class="btn btn-danger btn-sm" 
                            data-id="<?php echo $record['id']; ?>"
                            data-routing_number="<?php echo htmlspecialchars($record['routing_number'], ENT_QUOTES, 'UTF-8'); ?>"
                            onclick="deleteRecord(<?php echo $record['id']; ?>, '<?php echo htmlspecialchars($record['routing_number'], ENT_QUOTES, 'UTF-8'); ?>')">
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="10">No records found.</td>
        </tr>
    <?php endif; ?>
</tbody>




        <!-- end content -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Application Entry</h5>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    <input type="hidden" id="editId" name="id">
                    
                    <div class="mb-3">
                        <label for="editRoutingNumber" class="form-label">Routing Number</label>
                        <input type="text" class="form-control" id="editRoutingNumber" name="routing_number" required>
                    </div>

                    <div class="mb-3">
                        <label for="editName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="editName" name="full_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editParticular" class="form-label">Particular</label>
                        <input type="text" class="form-control" id="editParticular" name="particular" required>
                    </div>

                    <div class="mb-3">
                        <label for="editDateReceived" class="form-label">Date Received</label>
                        <input type="datetime-local" class="form-control" id="editDateReceived" name="date_received" required>
                    </div>

                    <div class="mb-3">
                        <label for="editReleasedDateTime" class="form-label">Date & Time Released from CENRO</label>
                        <input type="datetime-local" class="form-control" id="editReleasedDateTime" name="date_time_released_from_cenro" required>
                    </div>

                    <div class="mb-3">
                        <label for="editReleaseFromDateTime" class="form-label">Date & Time Released From</label>
                        <input type="datetime-local" class="form-control" id="editReleaseFromDateTime" name="date_time_released_from" required>
                    </div>

                    <div class="mb-3">
                        <label for="editResponsiblePerson" class="form-label">Responsible Person</label>
                        <input type="text" class="form-control" id="editResponsiblePerson" name="responsible_person" required>
                    </div>

                    <div class="mb-3">
                        <label for="editRemarks" class="form-label">Remarks</label>
                        <input type="text" class="form-control" id="editRemarks" name="remarks" required>
                    </div>
                    
                    <div class="mb-3">
    <label for="editActedDate" class="form-label">Acted Date</label>
    <input type="datetime-local" class="form-control" id="editActedDate" name="acted_date" required>
</div>


                    <div class="mb-3">
                        <label for="editSections" class="form-label">Sections</label>
                        <select class="form-control" id="editSections" name="sections" required>
                            <option value="Admin/Planning">Admin/Planning</option>
                            <option value="RPS">RPS</option>
                            <option value="CDS">CDS</option>
                            <option value="MES">MES</option>
                            <option value="PAMO">PAMO</option>
                            <option value="Special Concern">Special Concern</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="staticBackdropLabel">Add Application Entry</h1>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    <!-- Other form fields -->
                    <div class="mb-3">
                        <label for="routingNumber" class="form-label">Routing Number</label>
                        <input type="text" class="form-control" id="routingNumber" name="routing_number" placeholder="Enter routing number" required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="full_name" placeholder="Enter Full name" required>
                    </div>

                    <div class="mb-3">
                        <label for="particular" class="form-label">Particular</label>
                        <input type="text" class="form-control" id="particular" name="particular" placeholder="Enter particular" required>
                    </div>

                    <div class="mb-3">
                        <label for="dateReceived" class="form-label">Date Received</label>
                        <input type="datetime-local" class="form-control" id="dateReceived" name="date_received" required>
                    </div>

                    <div class="mb-3">
                        <label for="releasedDateTime" class="form-label">Date & Time Released from CENRO Office</label>
                        <input type="datetime-local" class="form-control" id="releasedDateTime" name="date_time_released_from_cenro" required>
                    </div>

                    <div class="mb-3">
                        <label for="releaseFromDateTime" class="form-label">Date & Time Released From</label>
                        <input type="datetime-local" class="form-control" id="releaseFromDateTime" name="date_time_released_from" required>
                    </div>

                    <div class="mb-3">
                        <label for="responsiblePerson" class="form-label">Responsible Person</label>
                        <input type="text" class="form-control" id="responsiblePerson" name="responsible_person" placeholder="Enter responsible person" required>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter remarks" required>
                    </div>

                    <div class="mb-3">
                        <label for="actedDate" class="form-label">Acted Date</label>
                        <input type="datetime-local" class="form-control" id="actedDate" name="acted_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="sections" class="form-label">Sections</label>
                        <select class="form-control" id="sections" name="sections" required>
                            <option value="Admin/Planning">Admin/Planning</option>
                            <option value="RPS">RPS</option>
                            <option value="CDS">CDS</option>
                            <option value="MES">MES</option>
                            <option value="PAMO">PAMO</option>
                            <option value="Special Concern">Special Concern</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" name="btn-save">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Populate modal with existing data when edit button is clicked
    $(".edit-btn").click(function () {
        $("#editId").val($(this).data("id"));
        $("#editRoutingNumber").val($(this).data("routing_number"));
        $("#editName").val($(this).data("full_name"));
        $("#editParticular").val($(this).data("particular"));
        $("#editReleasedDateTime").val($(this).data("date_time_released_from_cenro"));
        $("#editReleaseFromDateTime").val($(this).data("date_time_released_from"));
        $("#editResponsiblePerson").val($(this).data("responsible_person"));
        $("#editRemarks").val($(this).data("remarks"));
        $("#editSections").val($(this).data("sections"));
        $("#editDateReceived").val($(this).data("date_received"));  
        $("#editActedDate").val($(this).data("acted_date"));        // Populate Date Acted
    });

    // Handle form submission for updating
    $("#updateForm").submit(function (e) {
        e.preventDefault();

        // Basic validation to ensure fields are not empty
        if ($("#editRoutingNumber").val().trim() === "") {
            Swal.fire({
                icon: "warning",
                title: "Missing Input!",
                text: "Routing number cannot be empty.",
            });
            return;
        }

        $.ajax({
            url: "app_edit.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json", // Ensure JSON response parsing
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Record updated successfully.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: res.message || "Duplicate Routing Number detected.",
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong! Please try again.",
                    footer: "<small>Error: " + error + "</small>"
                });
            }
        });
    });
});
</script>


<script>
    // JavaScript for handling delete confirmation and AJAX request

    $(document).ready(function () {
        // Handle delete button click
        $(".btn-danger").click(function () {
            var recordId = $(this).data("id");
            var routingNumber = $(this).data("routing_number"); // Assuming routing_number is available in the data attribute
            
            // Show SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You will not be able to recover this record with Routing Number: " + routingNumber,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If "Yes" is clicked, make the AJAX request to delete the record
                    $.ajax({
                        url: "app_delete.php", // PHP script for deletion
                        type: "POST",
                        data: { id: recordId },
                        success: function (response) {
                            // Parse the response from PHP
                            var res = JSON.parse(response);
                            if (res.success) {
                                // Show success alert and reload the page
                                Swal.fire(
                                    'Deleted!',
                                    'Your record with Routing Number ' + routingNumber + ' has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page to reflect changes
                                });
                            } else {
                                // Show error alert in case of failure
                                Swal.fire(
                                    'Error!',
                                    res.message || 'There was an error deleting the record.',
                                    'error'
                                );
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // In case of an AJAX error, show the error message
                            Swal.fire(
                                'Error!',
                                'An unexpected error occurred: ' + errorThrown,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
<script>
$(document).ready(function () {
    // Handle form submission for "Add Data"
    $("form[action='#']").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "app_add.php", // Your PHP script for adding the record
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                var res = JSON.parse(response); // Parse JSON response
                
                if (res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Added!",
                        text: "Record has been added successfully.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Reload the page to reflect the new record
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Duplicate Routing Number!",
                        text: res.message // Show error message from PHP
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong! Please try again."
                });
            }
        });
    });
});
</script>


<script>
    $('table').DataTable();
</script>



<?php
include 'footer.php';
?>