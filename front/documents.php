<?php
include 'header.php';
?>

<body class="hold-transition layout-fixed">
    <div class="wrapper">
        <?php include 'navbar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="text-center">Documents Transmittal Form</h1>
                </div>
            </div>

            <?php
            $sql = "SELECT project_name, particular, amount_remarks FROM transmit_docs";
            $result = $conn->query($sql);
            if ($result === false) {
                die("Error: " . $conn->error);
            }
            ?>

            <div class="container-fluid">
                <div class="d-flex mb-3">
                    <!-- Dropdowns for filtering by Year and Month -->
                    <select id="filterYear" class="form-control mr-2">
                        <?php
                        $currentYear = date("Y");
                        for ($year = $currentYear; $year >= 1969; $year--) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>

                    <select id="filterMonth" class="form-control">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>

                <div class="d-flex mb-2">
                    <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#addDataModal">Add Data</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#exportPdfModal">Export PDF</button>
                    
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table no-wrap table-striped" id="data-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Project Name</th>
                                        <th>Particular</th>
                                        <th>Amount/Remarks</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
    <?php
    if ($result->num_rows > 0) {
        $counter = 1;  // Initialize counter
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $counter++ . "</td>  <!-- Display the counter and increment it -->
                <td>" . $row["project_name"] . "</td>
                <td>" . $row["particular"] . "</td>
                <td>" . ($row["amount_remarks"] ? $row["amount_remarks"] : "Pending") . "</td>
               
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
    }
    $conn->close();
    ?>
</tbody>

                            </table>
                        </div>
                    </div>
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
                    <form id="addDataForm">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" class="form-control" name="project_name" required>
                        </div>
                        <div class="form-group">
                            <label>Particular</label>
                            <input type="text" class="form-control" name="particular" required>
                        </div>
                        <div class="form-group">
                            <label>Amount/Remarks</label>
                            <textarea class="form-control" name="amount_remarks" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date">
                        </div>
                       
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <!-- Export PDF Modal -->
<div class="modal fade" id="exportPdfModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export PDF</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="exportPdfForm">
                    <!-- FOR Input Field -->
                    <div class="form-group">
                        <label>FOR</label>
                        <input type="text" class="form-control" name="for" required>
                    </div>

                    <!-- FOR Address Input Field -->
                    <div class="form-group">
                        <label>FOR Address</label>
                        <input type="text" class="form-control" name="for_address" required>
                    </div>

                    <!-- ATTENTION Input Field -->
                    <div class="form-group">
                        <label>ATTENTION</label>
                        <input type="text" class="form-control" name="attention" required>
                    </div>

                    <!-- ATTENTION Address Input Field -->
                    <div class="form-group">
                        <label>ATTENTION Address</label>
                        <input type="text" class="form-control" name="attention_address" required>
                    </div>

                    <!-- FROM Input Field -->
                    <div class="form-group">
                        <label>FROM</label>
                        <input type="text" class="form-control" name="from" required>
                    </div>

                    <!-- SUBJECT Input Field -->
                    <div class="form-group">
                        <label>SUBJECT</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>

                    <!-- Message Input Field -->
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="message" rows="4" required></textarea>
                    </div>

                    <!-- Month Dropdown (set to default value) -->
                    <div class="form-group">
                        <label>Select Month</label>
                        <select class="form-control" name="month" required>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>

                    <!-- Year Dropdown (set to default value) -->
                    <div class="form-group">
                        <label>Select Year</label>
                        <select class="form-control" name="year" required>
                            <?php
                            $currentYear = date("Y");
                            for ($year = $currentYear; $year >= 1969; $year--) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-danger">Export</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        // Initialize DataTables for sorting functionality
        var table = $('#data-table').DataTable();

        // Filter table based on selected year and month
        $('#filterYear, #filterMonth').change(function() {
            var year = $('#filterYear').val();
            var month = $('#filterMonth').val();
            
            // Use DataTable's search API to filter the date_of_request column
            // Format the search string as "YYYY-MM" to match the year and month part of "YYYY-MM-DD"
            var searchString = year + '-' + month;

            // Apply the search filter to the first column (date_of_request)
            table.column(0).search(searchString).draw();
        });

        // Handle form submission for adding data
        $("#addDataForm").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: "transmit_docs_add.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: "Data added successfully!",
                        icon: "success",
                        confirmButtonText: "Close"
                    }).then(() => {
                        $("#addDataModal").modal("hide");
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire("Error", "Failed to insert data.", "error");
                }
            });
        });

        // Initialize row selection for the Export PDF modal (optional)
        $('#data-table tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected');
        });

        // When Export PDF modal is about to show
        $("#exportPdfModal").on("show.bs.modal", function(e) {
            const selectedRow = $("table tr.selected");

            if (selectedRow.length) {
                const dateOfRequest = selectedRow.find("td:eq(0)").text(); // Format: YYYY-MM-DD
                const divSecUnitServed = selectedRow.find("td:eq(1)").text();
                const requestDescription = selectedRow.find("td:eq(2)").text();
                const dateFinished = selectedRow.find("td:eq(3)").text();
              

                // Populate hidden fields
                $("input[name='date_of_request']").val(dateOfRequest);
                $("input[name='div_sec_unit_served']").val(divSecUnitServed);
                $("input[name='request_description']").val(requestDescription);
                $("input[name='date_finished']").val(dateFinished);
              

                // Extract year and month from date_of_request
                if (dateOfRequest) {
                    const [year, month] = dateOfRequest.split("-"); // Split YYYY-MM-DD format
                    
                    // Set dropdown values
                    $("select[name='month']").val(month.padStart(2, '0')); // Ensure 2-digit format (e.g., "01")
                    $("select[name='year']").val(year);
                }
            } else {
                // Default to current month & year if no row is selected
                const today = new Date();
                const currentYear = today.getFullYear();
                const currentMonth = String(today.getMonth() + 1).padStart(2, '0'); // Get month (1-12)

                $("select[name='month']").val(currentMonth);
                $("select[name='year']").val(currentYear);
            }
        });

        // Handle form submission for exporting PDF
        $("#exportPdfForm").on("submit", function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            window.open("transmit_docs_pdf.php?" + formData, "_blank");
            $("#exportPdfModal").modal("hide");
        });
    });
</script>


</body>

<?php include 'footer.php'; ?>
