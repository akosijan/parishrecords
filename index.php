<?php
if (isset($_SESSION['login_userid'])) {
    header('location: admin/home.php');
} else {
    header('location: login/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
</head>

<body>
    <h1>welcome!</h1>
</body>

</html>