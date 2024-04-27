<?php
include 'conn.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM login WHERE username='$username'");
$data = mysqli_fetch_assoc($query);
$nama_petugas = $data["nama_petugas"];

if (isset($_GET['del'])) {
    $del = $_GET['del'];
    $sql = mysqli_query($conn, "DELETE FROM keranjang WHERE id='$del'");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $edit = mysqli_query($conn, "UPDATE keranjang SET qty = '$qty' where id = '$id'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman User</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="DataTables/DataTables-1.11.5/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="DataTables/datatables.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg" style="background-color:#2B78e4;padding:0px;border-bottom:2px solid black;">
        <div class="container-fluid">
            <a href="#" class="navbar-brand d-flex">
                <img src="image/kasir.png" width="55px" height="47px" alt="">
                <p class="fs-4 fw-bolder text-white" style="margin:5px;">KASIRGADD</p>
            </a>
            <div class="" style="background-color:black; align-self:stretch; width:2px; "></div>
            <div class="row text-center">
                <p>Jam</p>
                <p class="fs-4 fw-bolder text-white" id="jam"></p>
            </div>
            <div class="" style="background-color:black; align-self:stretch; width:2px; "></div>
            <div class="row text-center">
                <p>Tanggal</p>
                <p class="fs-4 fw-bolder text-white">
                    <?php
                    setlocale(LC_TIME, 'id_ID');
                    $tanggal = strftime('%d %B %Y');
                    echo '' . $tanggal;
                    ?>
                </p>
            </div>
            <div class="" style="background-color:black; align-self:stretch; width:2px; "></div>
            <div class="row text-center">
                <p>Nama Kasir</p>
                <p class="fs-4 fw-bolder text-white">
                    <?= $nama_petugas; ?>
                </p>
            </div>
        </div>
    </nav>



    </div>
<div class="mx-4 mt-4">
    <h1>Stok Barang</h1>
</div>

    <div class="mx-4 mt-4">
        <div class="row d-flex">
            <div class="">
                <div class="table-responsive">
                <table id="table_barang" class="table table-stripped table-bordered ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Tanggal Input</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $sql = 'SELECT * FROM barang';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['kode_barang']; ?></td>
                                    <td><?= $row['nama_barang']; ?></td>
                                    <td><?= $row['harga']; ?></td>
                                    <td><?= $row['stock']; ?></td>
                                    <td><?= $row['created_at']; ?></td>
                                    
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="updateModal<?= $row['id']; ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                
                                                <div class="mx-4 mt-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Kode Barang</label>
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <input id="kode_barang" type="text" name="kd" class="form-control" value="<?= $row['kode_barang']; ?>"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Nama Barang</label>
                                                        <input id="kode_barang" type="text" name="nb" class="form-control"  value="<?= $row['nama_barang']; ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Harga</label>
                                                        <input id="kode_barang" type="number" name="hrg" class="form-control"  value="<?= $row['harga']; ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="form-group">
                                                        <label for="kode_barang">Stok</label>
                                                        <input id="kode_barang" type="number" name="stock"
                                                            class="form-control"  value="<?= $row['stock']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="update" class="btn btn-primary">Save
                                                        changes</button>
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
    <div class="mx-4 mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="logout.php" onclick="return confirm('Yakin ingin logout?')"
                class="btn py-3 rounded-0 border-dark border-2 fw-bolder mb-2 text-white fs-3"
                style="min-width:300px;background-color:#2B78e4;">Logout</a>
            <a href="index.php" class="btn py-3 rounded-0 border-dark border-2 fw-bolder mb-2 text-white fs-3"
                style="min-width:300px;background-color:#2B78e4;">Kembali</a>
           
        </div>
    </div>

    <script src="sweetalert/dist/sweetalert2.min.js"></script>
    <script src="jquery/jquery-3.7.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/jquery.slim.min.js"></script>
    <script src="DataTables/DataTables-1.11.5/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables/datatables.js"></script>
    <script>
        $(document).ready(function () {
            $('#table_barang').DataTable();
        });
    </script>
    <script>
        function displayTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            var timeString = hours.toString().padStart(2, '0') + ":" + minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
            document.getElementById('jam').innerHTML = timeString;
        }
        setInterval(displayTime, 1000);
    </script>
</body>

</html>