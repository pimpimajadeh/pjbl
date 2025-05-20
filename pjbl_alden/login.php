<?php
include 'koneksi.php';
 $error = '';  
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
 }
 $stmt = $conn->prepare('SELECT * FROM user WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        if ($password === $data['Password']) {
            $_SESSION['id_pengguna'] = $data['id_pengguna'];
            $_SESSION['Nama'] = $data['Nama'];
            $_SESSION['role'] = $data['role'];
            if ($data['role'] == 'admin') {
                header("location: admin_dashboard.php");
            } else {
                header("location: user_dashboard.php");
            }
            exit();
        } else {
            $error = "password salah";
        }
    } else {
        $error = "email tidak terdaftar";
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>E-Gallery Sign Up</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(255, 255, 255);
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .left-panel {
            flex: 1;
            background-color: #333;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .logo {
            width: 300px;
        }
        .brand-name {
            font-size: 24px;
            margin-top: 10px;
        }
        .input-field {
            width: 90vh;
            padding: 10px;
            margin-bottom: 10px;
        }
        .login-button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        .login-link {
            margin-top: 10px;
            text-decoration: none;
            color: black;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
  <div class="container">
    <div class="left-panel">
      <h1>Welcome</h1>
      <img src="icon egallery.png" alt="E-Gallery Logo" class="logo" />
    </div>
    <form method="POST" action="">
        <div class="right-panel">
            <h2>Login</h2>
            <label>Email:</label><br>
            <input type="email"  class="input-field">
            <label>Password:</label><br>
            <input type="password" class="input-field">
            <button class="login-button">Login</button>
            <p class="login-link">New Here?<a href="register.php">Register</a></p>
        </div>
    </form>
  </div>
</body>
</html>
