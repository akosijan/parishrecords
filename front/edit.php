<?php
include 'header.php';
include 'db_connect.php'; // Ensure database connection is included

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM cenro_release_info WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application Entry</title>
    <link rel="stylesheet" href="edit.css">
</head>

<body>
    <div class="modal show d-block" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Edit Application Entry</h1>
                </div>
                <div class="modal-body">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $record['id']; ?>">

                        <div class="mb-3">
                            <label for="routingNumber">Routing Number</label>
                            <input type="number" class="form-control" name="routing_number" value="<?php echo $record['routing_number']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" name="full_name" value="<?php echo $record['full_name']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="particular">Particular</label>
                            <input type="text" class="form-control" name="particular" value="<?php echo $record['particular']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="dateTimeReleasedCenro">Date & Time Released from CENRO Office</label>
                            <input type="datetime-local" class="form-control" name="date_time_released_from_cenro" value="<?php echo $record['date_time_released_from_cenro']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="dateTimeReleased">Date & Time Released From</label>
                            <input type="datetime-local" class="form-control" name="date_time_released_from" value="<?php echo $record['date_time_released_from']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="responsiblePerson">Responsible Person</label>
                            <input type="text" class="form-control" name="responsible_person" value="<?php echo $record['responsible_person']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="sections">Sections</label>
                            <input type="text" class="form-control" name="sections" value="<?php echo $record['sections']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" name="remarks" value="<?php echo $record['remarks']; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="app_entry.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>