<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usernameOrEmail = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
  $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];

      // Redirect based on specific user
      $username = $user['username'];
      $email = $user['email'];

      if ($username === 'sunjoy' || $email === 'sonjoyp6767@gmail.com') {
        header("Location: ../Transport_Monitoring_dashboard.html");
      } elseif ($username === 'zawad' || $email === 'zawad@gmail.com') {
        header("Location: ../packaging_dashboard.html");
      } else {
        header("Location: ../dashboard.html");
      }

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
