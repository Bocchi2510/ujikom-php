<?php
include '../conn.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}
// nama kasir
$username = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM login WHERE username='$username'");
$row = mysqli_fetch_assoc($query);
$nama_admin = $row["nama_petugas"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../DataTables/DataTables-1.11.5/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../DataTables/datatables.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Dashboard Admin</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="bg-primary" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 text-white fs-4 fw-bold text-uppercase border-bottom">
                KASIRGADD</div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="petugas.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-user-circle me-2"></i>Petugas</a>
                <a href="produk.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-chart-line me-2"></i>Produk</a>
                <a href="member.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-paperclip me-2"></i>Member</a>
                <a href="riwayat.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-book me-2"></i>Riwayat</a>
            </div>
        </div>

        <div id="page-content-wrapper" style="background-color:#DDDDDD;">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?= $nama_admin; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../logout.php" onclick="return confirm('Yakin mau keluar?')">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <p class="fs-5">Total Produk</p>
                                <h3 class="fs-2">
                                    2

                                </h3>
                                <a href="produk.php">view details</a>
                            </div>
                            <i class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <div>
                                    <p class="fs-5">Member</p>
                                    <h3 class="fs-2">3</h3>
                                    <a href="produk.php">view details</a>
                                </div>
                            </div>
                            <i class="fas fa-paperclip fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <div>
                                    <p class="fs-5">Petugas</p>
                                    <h3 class="fs-2">2</h3>
                                    <a href="produk.php">view details</a>
                                </div>
                            </div>
                            <i class="fas fa-user-circle fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/jquery.slim.min.js"></script>
    <script src="../DataTables/DataTables-1.11.5/js/dataTables.bootstrap.min.js"></script>
    <script src="../DataTables/datatables.js"></script>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function() {
            el.classList.toggle("toggled");
        };
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>