<?php
include 'db_connect.php';
include 'header.php';

$success = '';
$error = '';
$showModal = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname   = $_POST['firstname'];
    $lastname    = $_POST['lastname'];
    $birthdate   = $_POST['birthdate'];
    $gender      = $_POST['gender'];
    $birthplace  = $_POST['birthplace'];
    $book_no     = $_POST['book_no'];
    $suffix = $_POST['suffix'] ?? ''; 
    $page_no     = $_POST['page_no'];

    $stmt = $conn->prepare("INSERT INTO baptism_tbl 
        (firstname, lastname, suffix, birthdate, gender, birthplace, book_no, page_no)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssss", $firstname, $lastname, $suffix, $birthdate, $gender, $birthplace, $book_no, $page_no);

    if ($stmt->execute()) {
        $success = "Record saved successfully!";
        $showModal = true;
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Baptism Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Optional if you have a shared style -->
</head>
<body class="hold-transition layout-fixed">
<div class="wrapper">
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper" style="margin-top: 20px;">
        <div class="container">
            <h2 class="my-4" style="text-align: left; font-weight: bold; font-size: 30px;">
  Baptism Record Form
</h2>


            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="row g-3" id="baptismForm">
                <div class="col-md-6">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label for="suffix" class="form-label">Suffix</label>
                    <select name="suffix" id="suffix" class="form-select">
                             <option value="">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-select" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="birthplace" class="form-label">Birthplace</label>
                    <input type="text" name="birthplace" id="birthplace" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="book_no" class="form-label">Book No</label>
                    <input type="text" name="book_no" id="book_no" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="page_no" class="form-label">Page No</label>
                    <input type="text" name="page_no" id="page_no" class="form-control">
                </div>

                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary px-5" id="submitBtn">
                        <span id="btnText">Save Record</span>
                        <span id="btnLoading" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="successModalLabel">Success</h5>
      </div>
      <div class="modal-body text-center">
        <?= $success ?>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const form = document.getElementById('baptismForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        btnText.textContent = "Saving...";
        btnLoading.classList.remove("d-none");
    });

    <?php if ($showModal): ?>
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
    setTimeout(() => {
        successModal.hide();
    }, 2000);
    <?php endif; ?>
</script>

</body>
</html>
