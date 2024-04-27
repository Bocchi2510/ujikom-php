<?php
include '../conn.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}
// nama petugas
$username = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM login WHERE username='$username'");
$row = mysqli_fetch_array($query);
$nama_admin = $row["nama_petugas"];
// kode admin
$query = mysqli_query($conn, "SELECT max(kode_petugas) as KodePetugas FROM login");
$row = mysqli_fetch_array($query);
$kodepetugas = $row["KodePetugas"];
if ($kodepetugas == '') {
    $kodepetugas = 'M0001';
} else {
    $urutan = (int) substr($kodepetugas, 1);
    $urutan++;
    $kodepetugas = "M" . sprintf("%04s", $urutan);
}
if (isset($_POST['insert'])) {
    $kp = $kodepetugas;
    $user = $_POST['user'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $np = $_POST['np'];
    $nt = $_POST['nt'];
    $level = $_POST['level'];
    $valid_level = ['petugas', 'admin'];
    if (!in_array($level, $valid_level)) {
        echo "<script>alert('Level tidak valid');window.location='petugas.php'</script>";
        exit;
    }

    $sql = mysqli_query($conn, "INSERT INTO `login`(`kode_petugas`, `username`, `password`, `nama_petugas`, `no_telp`, level) VALUES ('$kp','$user','$pass','$np','$nt','$level')");
    if ($sql) {
        echo "<script>alert('Data berhasil ditambahkan');window.location='petugas.php'</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan');window.location='petugas.php'</script>";
    }
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kp = $_POST['kp'];
    $user = $_POST['user'];
    $np = $_POST['np'];
    $nt = $_POST['nt'];
    $level = $_POST['level'];

    // Cek apakah password diisi atau tidak
    if (!empty($_POST['pass'])) {
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $updatePassword = ", `password`='$pass'";
    } else {
        $updatePassword = ""; // Biarkan password tetap seperti sebelumnya
    }

    $sql = mysqli_query($conn, "UPDATE `login` SET `kode_petugas`='$kp', `username`='$user', `nama_petugas`='$np', `no_telp`='$nt', `level`='$level' $updatePassword WHERE id='$id'");
    if ($sql) {
        echo "<script>alert('Data berhasil diubah');window.location='petugas.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah');window.location='petugas.php';</script>";
    }
}

error_reporting(0);
if ($kode = $_GET['del']) {
    $sql = "DELETE FROM login WHERE id='$kode'";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('Data berhasil Dihapus');window.location='petugas.php'</script>";
}
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
            <div class="sidebar-heading text-center py-4 text-white fs-4 fw-bold text-uppercase " style="border-bottom:2px solid white;margin-top:4px;">
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
                    <h2 class="fs-2 m-0">Data Petugas</h2>
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
            <div class="mx-3" style="border:1px solid black;"></div>
            <div class="container-fluid mx-3 me-3">
                <div class="d-flex justify-content-between me-3 g-3 my-2">
                    <!-- Button trigger modal -->
                    <h4>Data Petugas</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Petugas
                    </button>

                    <!-- Modal Insert -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal Input Petugas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="mx-4 mt-4">
                                        <div class="form-group">
                                            <label for="kode_petugas">Kode Petugas</label>
                                            <input id="kode_petugas" type="text" name="kp" class="form-control" value="<?= $kodepetugas; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="nama_member">Username</label>
                                            <input id="nama_member" type="text" name="user" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="diskon">password</label>
                                            <input id="diskon" type="password" name="pass" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="no_telp">Nama Petugas</label>
                                            <input id="no_telp" type="text" name="np" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="no_telp">Nama Telepon</label>
                                            <input id="no_telp" type="text" name="nt" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="no_telp">Role</label>
                                            <select name="level" class="form-control" required>
                                                <option>- Pilih -</option>
                                                <option name="petugas" value="petugas">Petugas</option>
                                                <option name="admin" value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="insert" class="btn btn-primary">Tambah
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="me-3">
                    <table id="example" class="table table-stripped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Petugas</th>
                                <th>Username</th>
                                <th>Nama Petugas</th>
                                <th>No Telepon</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $sql = 'SELECT * FROM login';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['kode_petugas']; ?></td>
                                    <td><?= $row['username']; ?></td>
                                    <td><?= $row['nama_petugas']; ?></td>
                                    <td><?= $row['no_telp']; ?></td>
                                    <td><?= $row['level']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal<?= $row['id']; ?>"><i class="fas fa-pen"></i></button> |
                                        <a class="btn btn-danger" onclick="return confirm('Yakin Data Mau Dihapus?')" href="petugas.php?del=<?= $row['id']; ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="updateModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal Update Petugas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="mx-4 mt-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Kode Petugas</label>
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <input id="kode_member" type="text" name="kp" class="form-control" value="<?= $row['kode_petugas']; ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_member">Username</label>
                                                        <input id="kode_member" type="text" name="user" class="form-control" value="<?= $row['username']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Password</label>
                                                        <input id="kode_barang" type="password" name="pass" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Nama Petugas</label>
                                                        <input id="kode_barang" type="text" name="np" class="form-control" value="<?= $row['nama_petugas']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">No Telepon</label>
                                                        <input id="kode_barang" type="number" name="nt" class="form-control" value="<?= $row['no_telp']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Role</label>
                                                        <select name="level" id="pet-select" class="form-control">
                                                            <option value="petugas" <?= $row['level'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                                            <option value="admin" <?= $row['level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="update" class="btn btn-primary">Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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