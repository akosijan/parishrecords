<?php
include 'db_connect.php';
include 'header.php';

function fetchAll($conn, $table) {
    $result = $conn->query("SELECT * FROM $table");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function formatColumnName($column) {
    return ucwords(str_replace('_', ' ', $column));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View PRMS Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="hold-transition layout-fixed">
<div class="wrapper">

<?php include 'navbar.php'; ?>

<div class="content-wrapper" style="margin-top: 20px;">
    <div class="container">
        <h2 class="fw-bold mb-4" style="font-size: 30px; text-align: left;">PRMS Database Records</h2>

        <ul class="nav nav-tabs" id="dataTabs" role="tablist">
            <?php
            $tabs = ['baptism' => 'Baptism', 'confirmation' => 'Confirmation', 'death' => 'Death', 'marriage' => 'Marriage'];
            $isFirst = true;
            foreach ($tabs as $key => $label): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $isFirst ? 'active' : '' ?>" id="<?= $key ?>-tab" data-bs-toggle="tab"
                            data-bs-target="#<?= $key ?>" type="button"><?= $label ?></button>
                </li>
                <?php $isFirst = false; endforeach; ?>
        </ul>

        <div class="tab-content mt-4" id="dataTabsContent">
            <?php
            $tables = [
                'baptism' => 'baptism_tbl',
                'confirmation' => 'confirmation_tbl',
                'death' => 'death_tbl',
                'marriage' => 'marriage_tbl'
            ];

            $isFirst = true;
            foreach ($tables as $key => $tableName):
                $records = fetchAll($conn, $tableName);
                $tableId = $key . "_table";
            ?>
                <div class="tab-pane fade <?= $isFirst ? 'show active' : '' ?>" id="<?= $key ?>" role="tabpanel">
                    <div class="table-responsive">
                        <table id="<?= $tableId ?>" class="table table-bordered table-striped table-sm datatable">
                            <thead class="table-dark">
                            <tr>
                                <th>Action</th>
                                <?php
                                if (!empty($records)) {
                                    foreach (array_keys($records[0]) as $col) {
                                        echo "<th>" . htmlspecialchars(formatColumnName($col)) . "</th>";
                                    }
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($records as $row) {
                                $id = $row['id'];
                                echo "<tr>";
                               echo "<td>
    <button class='btn btn-sm btn-warning me-1 edit-btn' 
            data-id='$id' 
            data-table='$tableName' 
            data-record='" . htmlspecialchars(json_encode($row), ENT_QUOTES) . "'>
        Edit
    </button>
    <button class='btn btn-sm btn-danger me-1 delete-btn' 
            data-id='$id' 
            data-table='$tableName'>
        Delete
    </button>
    <button class='btn btn-sm btn-success generate-cert-btn' 
            data-id='$id'>
        PDF
    </button>
</td>";

                                foreach ($row as $cell) {
                                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php $isFirst = false; endforeach; ?>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editModalBody"></div>
                <div class="modal-footer">
                    <input type="hidden" name="table" id="editTableName">
                    <input type="hidden" name="id" id="editRecordId">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table']) && isset($_POST['id'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    unset($_POST['table'], $_POST['id']);

    $updates = [];
    foreach ($_POST as $key => $value) {
        $value = $conn->real_escape_string($value);
        $updates[] = "`$key` = '$value'";
    }

    $sql = "UPDATE `$table` SET " . implode(", ", $updates) . " WHERE `id` = '$id'";
    $conn->query($sql);

    echo "<script>window.location='view_data.php';</script>";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $('.datatable').DataTable();

    $('.edit-btn').on('click', function () {
        const record = JSON.parse($(this).attr('data-record'));
        const modalBody = $('#editModalBody').html('');
        $('#editTableName').val($(this).attr('data-table'));
        $('#editRecordId').val($(this).attr('data-id'));

        for (const key in record) {
            const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            modalBody.append(`
                <div class="mb-3">
                    <label class="form-label">${label}</label>
                    <input type="text" class="form-control" name="${key}" value="${record[key]}" ${key === 'id' ? 'readonly' : ''}>
                </div>
            `);
        }

        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    });

    $('.delete-btn').on('click', function () {
        const id = $(this).attr('data-id');
        const table = $(this).attr('data-table');

        Swal.fire({
            title: 'Are you sure?',
            text: "You can't undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('', {
                    delete_id: id,
                    delete_table: table
                }, function () {
                    Swal.fire('Deleted!', 'Record has been deleted.', 'success').then(() => {
                        location.reload();
                    });
                }).fail(() => {
                    Swal.fire('Error', 'Delete failed.', 'error');
                });
            }
        });
    });
});

$('.generate-cert-btn').on('click', function () {
    Swal.fire({
        title: 'Placeholder',
        text: 'This is a placeholder for generating certificates.',
        icon: 'info',
        confirmButtonText: 'OK'
    });
});

</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'], $_POST['delete_table'])) {
    $id = $conn->real_escape_string($_POST['delete_id']);
    $table = $conn->real_escape_string($_POST['delete_table']);
    $conn->query("DELETE FROM `$table` WHERE `id` = '$id'");
    exit;
}
?>
</body>
</html>
