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
            <div class="sidebar-heading text-center py-4 text-white fs-4 fw-bold text-uppercase "
                style="border-bottom:2px solid white;margin-top:4px;">
                KASIRGADD</div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="petugas.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-user-circle me-2"></i>Petugas</a>
                <a href="produk.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-chart-line me-2"></i>Produk</a>
                <a href="member.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-paperclip me-2"></i>Member</a>
                <a href="riwayat.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-book me-2"></i>Riwayat</a>
            </div>
        </div>

        <div id="page-content-wrapper" style="background-color:#DDDDDD;">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Data Laporan</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?= $nama_admin; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../logout.php"
                                        onclick="return confirm('Yakin mau keluar?')">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="mx-3" style="border:1px solid black;"></div>
            <div class="container-fluid mx-3 me-3">
                <div class="d-flex justify-content-between me-3 g-3 my-2">
                    <!-- Button trigger modal -->
                    <h4>Data Laporan</h4>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#printModal">
                        Print
                    </button>



                </div>
                <div class="me-3">
                    <table id="example" class="table table-stripped table-bordered table-sm text-center">
                        <thead>
                            <tr>

                                <th>No</th>
                                <th>No Nota</th>
                                <th>Nama Petugas</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                                <th>QTY</th>
                                <th>Tanggal Transaksi</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $sql = 'SELECT * FROM laporan';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['kode_transaksi']; ?></td>
                                    <td><?= $row['nama_petugas']; ?></td>
                                    <td><?= $row['jumlah_barang']; ?></td>
                                    <td><?= $row['total_harga']; ?></td>
                                    <td><?= $row['qty']; ?></td>
                                    <td><?= $row['created_at']; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/jquery.slim.min.js"></script>
    <script src="../DataTables/DataTables-1.11.5/js/dataTables.bootstrap.min.js"></script>
    <script src="../DataTables/datatables.js"></script>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'print'
                ]
            });
        });
    </script>

</body>

</html>