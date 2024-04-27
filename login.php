<?php
include 'conn.php';
session_start();
if (isset($_SESSION['username'])) {
    if ($_SESSION['level'] === 'Admin') {
        header("Location: admin/index.php");
        exit;
    } elseif ($_SESSION['level'] === 'Petugas') {
        header("Location: index.php");
        exit;
    }
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM login WHERE username='$username'");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if (password_verify($password, $row['password'])) {
            if ($row['level'] === 'Admin') {
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 'Admin';
                echo "<script>alert('Selamat Datang di halaman Admin');window.location='admin/index.php';</script>";
                exit;
            } else if ($row['level'] === "Petugas") {
                $_SESSION["username"] = $username;
                $_SESSION["level"] = "Petugas";
                echo "<script>alert('Selamat Datang di halaman User');window.location='index.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Password Salah');window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan');window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: skyblue;
        }

        .login-container {
            border: 3px solid black;
            background-color: #DDDDDD;
            width: 750px;
            height: 370px;
            padding: 25px;
        }

        .form-input {
            border: 3px solid black;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="col-md-6 login-container rounded shadow">
                <div class="row">
                    <div class="col-md-6">
                        <img src="image/login.png" class="img-fluid" width="90%">
                    </div>
                    <div class="col-md-6 mt-4">
                        <h2 class="text-center mb-5 fw-bold">Login</h2>
                        <form action="" method="POST">
                            <div class="form-group mb-4">
                                <input type="text" name="username" class="form-control form-input" placeholder="enter username" required>
                            </div>
                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control form-input" placeholder="enter password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-success btn-block fw-bold form-control">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>