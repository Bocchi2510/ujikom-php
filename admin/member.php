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
// kode barang
$query = mysqli_query($conn, "SELECT max(kode_member) as kodemember FROM member");
$row = mysqli_fetch_assoc($query);
$kodemember = $row["kodemember"];
if($kodemember == ''){
    $kodemember = 'M0001';
}else{
    $urutan = (int) substr($kodemember, 1);
    $urutan++;
    $kodemember = 'M' . sprintf('%04s', $urutan);
}
if (isset($_POST['insert'])) {
    $km = $kodemember;
    $nm = $_POST['nb'];
    $diskon = $_POST['diskon'];
    $alamat = $_POST['alamat'];
    $np = $_POST['np'];

    $sql = mysqli_query($conn, "INSERT INTO `member`( `kode_member`, `nama_member`, `diskon`, `alamat`, `no_telp`) VALUES ('$km','$nm','$diskon','$alamat','$np')");
    if ($sql) {
        echo "<script>alert('Data berhasil ditambahkan');window.location='member.php'</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan');window.location='member.php'</script>";
    }
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $km = $_POST['km'];
    $nm = $_POST['nm'];
    $diskon = $_POST['diskon'];
    $alamat = $_POST['alamat'];
    $np = $_POST['np'];

    $sql = mysqli_query($conn, "UPDATE `member` SET `kode_member`='$km',`nama_member`='$nm',`alamat`='$alamat',`diskon`='$diskon',`no_telp`='$np' WHERE id='$id'");
    if ($sql) {
        echo "<script>alert('Data berhasil di ubah');window.location='member.php';</script>";
    } else {
        echo "<script>alert('Data gagal tidak di ubah');window.location='member.php';</script>";
    }
}
error_reporting(0);
if ($kode = $_GET['del']) {
    $sql = "DELETE FROM member WHERE id='$kode'";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('Data berhasil Dihapus');window.location='member.php'</script>";
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
                    <h2 class="fs-2 m-0">Data Member</h2>
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
                    <h4>Data Member</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Member
                    </button>

                    <!-- Modal Insert -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal Input Member</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="mx-4 mt-4">
                                        <div class="form-group">
                                            <label for="kode_member">Kode Member</label>
                                            <input id="kode_member" type="text" name="km" class="form-control" value="<?= $kodemember; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="nama_member">Nama Member</label>
                                            <input id="nama_member" type="text" name="nb" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="nama_member">Diskon</label>
                                            <input id="nama_member" type="number" name="diskon" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="diskon">Alamat</label>
                                            <textarea id="diskon" type="text" name="alamat" class="form-control"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="mx-4">
                                        <div class="form-group">
                                            <label for="no_telp">No Telepon</label>
                                            <input id="no_telp" type="number" name="np" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="insert" class="btn btn-primary">Save
                                            changes</button>
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
                                <th>Kode Member</th>
                                <th>Nama Member</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Tanggal Input</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $sql = 'SELECT * FROM member';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['kode_member']; ?></td>
                                        <td><?= $row['nama_member']; ?></td>
                                        <td><?= $row['alamat']; ?></td>
                                        <td><?= $row['no_telp']; ?></td>
                                        <td><?= $row['created_at']; ?></td>
                                        <td>
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateModal<?= $row['id']; ?>"><i
                                                    class="fas fa-pen"></i></button> |
                                                     <a class="btn btn-danger"  onclick="return confirm('Yakin Data Mau Dihapus?')" href="member.php?del=<?= $row['id']; ?>"><i
                                                    class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="updateModal<?= $row['id']; ?>" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal Update Member</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                
                                                    <div class="mx-4 mt-4">
                                                        <div class="form-group">
                                                            <label for="kode_barang">Kode Member</label>
                                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                            <input id="kode_member" type="text" name="km" class="form-control" value="<?= $row['kode_member']; ?>"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="mx-4">
                                                        <div class="form-group">
                                                            <label for="kode_member">Nama Member</label>
                                                            <input id="kode_member" type="text" name="nm" class="form-control"  value="<?= $row['nama_member']; ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="mx-4">
                                                        <div class="form-group">
                                                            <label for="kode_barang">Alamat</label>
                                                            <input id="kode_barang" type="text" name="alamat" class="form-control"  value="<?= $row['alamat']; ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="mx-4">
                                                        <div class="form-group">
                                                            <label for="kode_barang">No Telepon</label>
                                                            <input id="kode_barang" type="number" name="np"
                                                                class="form-control"  value="<?= $row['no_telp']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
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

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>

</html>
