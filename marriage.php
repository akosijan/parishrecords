<?php
include 'config/db.php';

$success = '';
$error = '';
$showModal = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $suffix = $_POST['suffix'] ?? '';
    $husband_age = $_POST['husband_age'] ?? '';
    $husband_address = $_POST['husband_address'] ?? '';
    $husband_birthdate = $_POST['husband_birthdate'] ?? '';
    $book_no = $_POST['book_no'] ?? '';
    $page_no = $_POST['page_no'] ?? '';

    $husband_name = trim($firstname . ' ' . $lastname); // Concatenate names

    $stmt = $conn->prepare("INSERT INTO marriage_tbl 
        (husband_name, suffix, husband_age, husband_address, husband_birthdate, book_no, page_no)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssissss", $husband_name, $suffix, $husband_age, $husband_address, $husband_birthdate, $book_no, $page_no);

    if ($stmt->execute()) {
        $success = "Marriage record saved successfully!";
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
    <title>Marriage Record Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php include 'components/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Marriage Record Form</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3" id="marriageForm">

        <div class="col-md-5">
            <label for="firstname" class="form-label">Husband First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control" required>
        </div>

        <div class="col-md-5">
            <label for="lastname" class="form-label">Husband Last Name</label>
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

        <div class="col-md-3">
            <label for="husband_age" class="form-label">Husband Age</label>
            <input type="number" name="husband_age" id="husband_age" class="form-control">
        </div>

        <div class="col-md-5">
            <label for="husband_address" class="form-label">Husband Address</label>
            <input type="text" name="husband_address" id="husband_address" class="form-control">
        </div>

        <div class="col-md-4">
            <label for="husband_birthdate" class="form-label">Husband Birthdate</label>
            <input type="date" name="husband_birthdate" id="husband_birthdate" class="form-control">
        </div>

        <div class="col-md-3">
            <label for="book_no" class="form-label">Book No</label>
            <input type="text" name="book_no" id="book_no" class="form-control">
        </div>

        <div class="col-md-3">
            <label for="page_no" class="form-label">Page No</label>
            <input type="text" name="page_no" id="page_no" class="form-control">
        </div>

        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-success px-5" id="submitBtn">
                <span id="btnText">Save Record</span>
                <span id="btnLoading" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
        </div>
    </form>
</div>

<!-- Success Modal -->
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
const form = document.getElementById('marriageForm');
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
