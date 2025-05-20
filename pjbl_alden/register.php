<?php include 'koneksi.php'; ?>
<?php

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['Email']);
    $password = $_POST['Password'];
    $role = 'admin'; // default role user

    // Cek apakah email sudah terdaftar
    $cek = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        $error = "Email sudah digunakan";
    } else {

        $stmt = $conn->prepare("INSERT INTO user (Nama, Email, Password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $email, $password, $role);
        if ($stmt->execute()) {
            $success = "Registrasi berhasil. Silakan login.";
        } else {
            $error = "Gagal mendaftar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - E-Gallery </title>
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
            width: 80%;
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
            color: black;
        }
        .a{
            text-decoration: none;
            color: black;
        }
        .select{
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <div class="container">
    <div class="left-panel">
      <h1>Welcome</h1>
      <img src="icon egallery.png" alt="E-Gallery Logo" class="logo" />
    </div>
    <div class="right-panel">
      <h2>Register</h2>
      <input type="email"  class="input-field">
      <input type="password" class="input-field">
      <select class="select">
        <option>user</option>
        <option>admin</option>
        <option>author  </option>
      </select>
      <button class="login-button">Register</button>
      <p class="login-link">Have An Account?<a href="login.php">Login</a></p>
    </div>
  </div>
</body>
</html>