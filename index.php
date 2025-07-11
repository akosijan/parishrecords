<?php
<<<<<<< HEAD
if (isset($_SESSION['login_userid'])) {
    header('location: admin/home.php');
} else {
    header('location: login/login.php');
}

=======
>>>>>>> 6b9a19b0ea0c5cf6f035d8714d7915f7d502f311
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
</head>

<body>
    <h1>welcome!</h1>
=======
    <title>Parish Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include 'components/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Welcome to Parish Records</h1>
        <p class="text-center">Please select a category from the navigation bar.</p>
    </div>

    <!-- Bootstrap JS (for responsive navbar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

>>>>>>> 6b9a19b0ea0c5cf6f035d8714d7915f7d502f311
</body>

</html>