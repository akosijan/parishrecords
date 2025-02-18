<?php
session_start();

// Include the database connection file
include 'db_connect.php';

if (isset($_POST['btn-login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Store user data in session
            foreach ($user as $key => $value) {
                if ($key != 'password' && !is_numeric($key)) {
                    $_SESSION['login_' . $key] = $value;
                }
            }
            
            // Specifically store the username and role in session
            $_SESSION['login_username'] = $user['username'];
            $_SESSION['login_role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header('Location: ../admin/home.php');
                exit;
            } elseif ($user['role'] == 'user') {
                header('Location: ../user/home.php');
                exit;
            } elseif ($user['role'] == 'front') {
                header('Location: ../front/home.php');
                exit;
            } else {
                // If the role is unknown, handle it gracefully
                header('Location: index.php?error=Invalid role');
                exit;
            }

        } else {
            header('Location: index.php?error=Incorrect password');
            exit;
        }
    } else {
        header('Location: index.php?error=User not found');
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
