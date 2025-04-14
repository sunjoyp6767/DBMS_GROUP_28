<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Successful login: redirect to dashboard
            header("Location: ../dashboard.html");
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='../index.html#login';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='../index.html#login';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
