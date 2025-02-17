<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['userid'], $_POST['role'], $_POST['username'], $_POST['email'])) {
        echo json_encode(["status" => "error", "message" => "Missing fields"]);
        exit();
    }

    $userid = intval($_POST['userid']);
    $role = trim($_POST['role']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if (empty($userid) || empty($role) || empty($username) || empty($email)) {
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET role=?, username=?, email=? WHERE userid=?");
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("sssi", $role, $username, $email, $userid);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
