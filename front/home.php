<?php
include 'header.php'; // session_start() is already here

// Check if the user is logged in
if (!isset($_SESSION['login_userid'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// Retrieve the username and role from session
$username = isset($_SESSION['login_username']) ? $_SESSION['login_username'] : 'Guest';
$role = isset($_SESSION['login_role']) ? $_SESSION['login_role'] : 'Unknown';
?>

<body class="hold-transition layout-fixed">
    <div class="wrapper">

        <?php
        include 'navbar.php';
        ?>

        <!-- content -->
        <div class="content-wrapper">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <p>Your role is: <?php echo htmlspecialchars($role); ?></p>
        </div>
        <!-- end content -->

    </div>
</body>

<?php
include 'footer.php';
?>
