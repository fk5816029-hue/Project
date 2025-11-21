<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    if (!$email || !$pass) {
        echo "All fields are required!";
        exit;
    }

    $sql = "SELECT user_id, name, email, password FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if ($user['password'] === $pass) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            echo "success";
            exit;
        } else {
            echo "Incorrect password!";
            exit;
        }
    } else {
        echo "Email not registered!";
        exit;
    }

    mysqli_close($conn);
}