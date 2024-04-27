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
$kode_petugas = $data['kode_petugas'];
$no_telp = $data['no_telp'];

$nota = "INV" . rand(100000, 999999);

$totalitem = 0;
$totalqty = 0;
if (isset($_GET['del'])) {
    $del = $_GET['del'];
    $sql = mysqli_query($conn, "DELETE FROM keranjang WHERE id='$del'");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $edit = mysqli_query($conn, "UPDATE keranjang SET qty = '$qty' WHERE id = '$id'");
    header("Location: index.php");
    exit();
}
$barang = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM login WHERE username='$username'");
if (isset($_POST["insert-print"])) {
    $no = $_POST["not"];
    $jb = $_POST["jumlah_barang"];
    $th = $_POST["total_harga"];
    $qty = $_POST["qty"];
    $nama_petugas = $_POST["nama_petugas"];
    $sql = mysqli_query($conn, "INSERT INTO `laporan`( `kode_transaksi`, `jumlah_barang`, `total_harga`, `qty`, `nama_petugas`) VALUES ('$no','$jb','$th','$qty','$nama_petugas')");
    header("Location: index.php");
    exit();
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
    <style>
        @media print {

            #print .print-none {
                display: none !important;
            }

            .print-none {
                display: none !important;
            }

            #print .print-show {
                display: block !important;
            }
        }
    </style>
</head>

<body>
    <main class="" id="print">
        <div class=" print-none">
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
            <div class="d-flex align-items-center justify-content-between mx-4 mt-4 gap-2">
                <!-- Button Member -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-member">
                    Member
                </button>

                <!-- Modal Member-->
                <div class="modal fade" id="modal-member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal Member</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table id="table_tambah_member" class="table table-stripped table-bordered table-sm">
                                    <thead>
                                        <tr>

                                            <th>No</th>
                                            <th>Kode Member</th>
                                            <th>Nama Member</th>
                                            <th>Diskon</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
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
                                                <td><?= $row['diskon']; ?>%</td>
                                                <td><?= $row['alamat']; ?></td>
                                                <td><?= $row['no_telp']; ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm tambah-diskon" data-kode="<?= $row['kode_member']; ?>" data-diskon="<?= $row['diskon']; ?>">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>

                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button Modal tambah barang -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-barang">
                    Tambah Barang
                </button>

                <!-- Modal Member-->
                <div class="modal fade" id="modal-tambah-barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal tambah Barang</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table id="table_tambah_barang" class="table table-stripped table-bordered table-sm">
                                    <thead>
                                        <tr>

                                            <th>No</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
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
                                                <td>
                                                    <form action="proses/tambah-barang.php" method="get">
                                                        <input type="hidden" name="kode_barang" value="<?= $row['kode_barang']; ?>">
                                                        <button type="submit" class="btn btn-warning mb-2" id="pilihmember">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="mx-4 mt-4">
                <div class="row d-flex">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table id="table_barang" class="table table-stripped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>QTY</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $total_diskon_barang = 0;
                                    $hasil = 0;
                                    $total_setelah_diskon = 0;
                                    $kembalian = 0;
                                    $totalitem = 0;
                                    $totalqty = 0;
                                    $sql = mysqli_query($conn, "SELECT keranjang.*, barang.diskon, barang.nama_barang FROM keranjang INNER JOIN barang ON keranjang.kode_produk = barang.kode_barang");
                                    while ($data = mysqli_fetch_assoc($sql)) {
                                    ?>
                                        <tr>
                                            <form method="post" onsubmit="return addToCart(this);">
                                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                <td><?= $no++; ?></td>
                                                <td><?= $data['kode_produk']; ?></td>
                                                <td><?= $data['nama_produk']; ?></td>
                                                <td><input type="number" name="qty" class="form-control form-control-sm" style="text-align: center; width: 50px;" value="<?= $data['qty']; ?>"></td>


                                                <td>Rp.<?= number_format($data['harga']); ?></td>
                                                <?php
                                                $totalharga = $data['harga'] * $data['qty'];
                                                $hasil += $totalharga;
                                                ?>
                                                <td>Rp.<?= number_format($totalharga); ?></td>
                                                <td>
                                                    <input type="hidden" name="kode_produk" value="<?= $data['kode_produk']; ?>">
                                                    <a href="?del=<?= $data['id']; ?>" class="btn btn-danger btn-sm mb-2">
                                                        Batal
                                                    </a>
                                                    <div class="vr"></div>
                                                    <button type="submit" name="update" class="btn btn-primary btn-sm mb-2">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php
                                        $total_pembelian = $hasil;
                                        if ($total_pembelian >= 100000) {
                                            $total_diskon = $total_diskon_barang;
                                            $total_harga_sebelum_diskon = $hasil;
                                            $total_setelah_diskon = $total_harga_sebelum_diskon * (100 - $total_diskon) / 100;
                                        } else {
                                            $total_setelah_diskon = $total_pembelian;
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col ">
                        <form method="post" action="">
                            <div class="row mb-3">
                                <div class="col-md-5 text-end">
                                    <label for="no">Sub Total</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no" class="form-control form-control-sm" value="Rp.<?= number_format($hasil); ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-5 text-end">
                                    <label for="kode_barang">Diskon</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="number" name="diskon" id="input_diskon" class="form-control form-control-sm" placeholder="0%" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-5 text-end">
                                    <label for="nama_barang">Total</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="total" id="nama_barang" class="form-control form-control-sm" value="Rp.<?= number_format($total_setelah_diskon); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-5 text-end">
                                    <label for="qty">Bayar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="bayar" id="qty" class="form-control form-control-sm" oninput="hitungKembalian()" placeholder="0">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-5 text-end">
                                    <label for="harga">Kembalian</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="kembalian" id="harga" class="form-control form-control-sm" placeholder="0" readonly>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="mx-4 mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="logout.php" onclick="return confirm('Yakin ingin logout?')" class="btn py-3 rounded-0 border-dark border-2 fw-bolder mb-2 text-white fs-3" style="min-width:300px;background-color:#2B78e4;">Logout</a>
                    <a href="stok.php" class="btn py-3 rounded-0 border-dark border-2 fw-bolder mb-2 text-white fs-3" style="min-width:300px;background-color:#2B78e4;">Stok Barang</a>
                    <div class="mx-2 px-2 mb-2 " style="min-width: 200px;border:2px solid #000;">
                        <p class=" d-flex justify-content-between">TOTAL ITEM: <?php
                                                                                include "conn.php";
                                                                                $sql = "SELECT count(id) as id FROM keranjang WHERE id >1";
                                                                                $query = mysqli_query($conn, $sql);
                                                                                $total = mysqli_fetch_assoc($query);
                                                                                echo "<span>" . $total['id'] . "<span>";
                                                                                ?> </p>
                        <p class="mb-2 d-flex justify-content-between">TOTAL QTY : <?php
                                                                                    include "conn.php";
                                                                                    $sql = "SELECT COALESCE(SUM(qty), 0) as qty FROM keranjang WHERE id > 1";
                                                                                    $query = mysqli_query($conn, $sql);
                                                                                    $qty = mysqli_fetch_assoc($query);
                                                                                    echo "<span>" . $qty['qty'] . "<span>";
                                                                                    ?></p>

                    </div>
                    <input type="hidden" name="total_item" value="<?= $item['id'] ?>">
                    <input type="hidden" name="total_qty" value="<?= $qty['qty'] ?>">
                    <input type="hidden" name="total_harga" value="<?= $total_setelah_diskon ?>">
                    <input type="hidden" id="totalDanDiskon" value="<?= $total_setelah_diskon ?>">
                    <input type="hidden" name="kode_petugas" value="<?= $kode_petugas ?>">
                    <div class="" id="printButton">
                        <input type="hidden" name="not" value="<?= $nota; ?>">
                        <input type="hidden" name="jumlah_barang" value="<?= $total['id']; ?>">
                        <input type="hidden" name="nota" value="<?= $total_setelah_diskon; ?>">
                        <input type="hidden" name="qty" value="<?= $qty['qty'] ?>">
                        <input type="hidden" name="nama_petugas" value="<?= $nama_petugas; ?>">
                        <button name="insert-print" type="submit" class="btn py-3 rounded-0 border-dark border-2 fw-bolder mb-2 text-white fs-3" style="min-width: 300px; background-color: #2B78E4;" onclick="window.print()"><i class="fa fa-print"></i> Cetak
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-none pt-5 px-4 print-show">
            <div class="row">
                <div class="col-12 text-center mb-2">
                    <h1 style="font-size:50px;font-weight:700;">KASIRGADD</h1>
                    <h5 class="mb-0">Isekai</h5>
                    <h5 class="mb-2">Tel : <?= $no_telp; ?></h5>
                </div>
                <div class="col-7">
                    <h5 class="mb-0" name="kode_transaksi" style="text-transform: uppercase;">INVOICE : <?= $nota; ?>
                    </h5>
                    <h5 class="mb-0" style="text-transform: uppercase;">KASIR : <?= $nama_petugas; ?></h5>
                </div>
                <div class="col-5">
                    <h5 class="mb-0" style="text-transform: uppercase;">TANGGAL : <?= date('d-m-Y') ?></h5>
                    <h5 class="mb-0" style="text-transform: uppercase;">PUKUL : <span id="jam2"></span></h5>
                </div>
                <div class="col-12 bg-secondary border my-3"></div>
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-1 text-center">
                            <h5 style="font-weight:700;">QTY</h5>
                        </div>
                        <div class="col">
                            <h5 style="font-weight:700;">PRODUK</h5>
                        </div>
                        <div class="col text-center">
                            <h5 style="font-weight:700;">HARGA</h5>
                        </div>
                        <div class="col text-end">
                            <h5 style="font-weight:700;">SUBTOTAL</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <?php
                    $hasil = 0;
                    $sql = mysqli_query($conn, "SELECT keranjang.*, barang.diskon, barang.nama_barang FROM keranjang INNER JOIN barang ON keranjang.kode_produk = barang.kode_barang");
                    while ($data = mysqli_fetch_assoc($sql)) {
                        $totalharga = $data['harga'] * $data['qty'];
                        $hasil += $totalharga;
                    ?>
                        <div class="row">

                            <div class="col-1 text-center">
                                <h4 id="qty{{ $penjualan->id }}"><?= $data['qty']; ?></h4>
                            </div>
                            <div class="col">
                                <h4><?= $data['nama_produk']; ?></h4>
                            </div>
                            <div class="col text-center">
                                <h4>Rp.<?= $data['harga'] ?></h4>
                            </div>
                            <div class="col text-end">
                                <h4 id="subtotal{{ $penjualan->id }}">Rp.<?= number_format($totalharga); ?></h4>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-12 bg-secondary border my-3"></div>
                <div class="col-12">
                    <div class="row" id="cekMember">
                        <div class="col">
                            <h4>Total Belanja</h4>
                            <h4>Bayar</h4>
                            <h4>Kembalian</h4>
                        </div>
                        <div class="col text-end">
                            <h4><span>Rp.<?= number_format($hasil) ?></span></h4>
                            <h4><span id="pembayaran"></span></h4>
                            <h4><span id="kembalian"></span></h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 bg-secondary border my-3"></div>
                <div class="col-12 text-center">
                    <h3>* Terima Kasih Telah Berbelanja Di Toko Kami *</h3>
                </div>
            </div><!-- end row -->
        </div><!-- end box print -->
    </main>
    <script>
        // Function to check stock before adding to cart
        function addToCart(form) {
            var qty = parseInt(form.qty.value);
            var stock = parseInt(form.stock.value);

            if (qty <= 0) {
                alert("Quantity must be greater than zero.");
                return false;
            }

            if (qty > stock) {
                alert("Sorry, there is not enough stock available.");
                return false;
            }

            // If everything is okay, submit the form
            return true;
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#pilihMember").change(function() {
                var member = $(this).val();
                var cekMember = $('#cekMember');
                if (member) {
                    cekMember.html(`
                <div class="col">
                    <h4>Total Belanja</h4>
                    <h4>Diskon</h4>
                    <h4>Total</h4>
                    <h4>Bayar</h4>
                    <h4>Kembalian</h4>
                </div>
                <div class="col text-end">
                    <h4><span id="totalBelanja">Rp.{{ number_format($totalHarga) }}</span></h4>
                    <h4><span>5%</span></h4>
                    <h4><span id="totalDiskon"></span></h4>
                    <h4><span id="pembayaran"></span></h4>
                    <h4><span id="kembalian"></span></h4>
                </div>`);
                }
            });
        });
    </script>
    <script>
        function printAll() {
            // Tampilkan semua konten yang semula disembunyikan untuk tampilan cetak
            $('.print-show').removeClass('d-none');

            // Lakukan pencetakan hanya pada bagian nota
            var printContents = document.getElementById('printArea').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

            // Sembunyikan kembali konten yang tidak perlu dicetak
            $('.print-show').addClass('d-none');
        }
    </script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/jquery.slim.min.js"></script>
    <script src="DataTables/DataTables-1.11.5/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_barang').DataTable();
        });
        $(document).ready(function() {
            $('#table_tambah_barang').DataTable();
        });
        $(document).ready(function() {
            $('#table_tambah_member').DataTable();
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
            document.getElementById('jam2').innerHTML = timeString;
        }
        setInterval(displayTime, 1000);
    </script>
    <script>
        function hitungKembalian() {
            var total = parseFloat(document.querySelector('#totalDanDiskon').value);
            var bayar = parseFloat(document.getElementById('qty').value);

            if (isNaN(bayar)) {
                bayar = 0;
            }

            var kembalian = bayar - total;

            var pembayaran = document.querySelector('#pembayaran');
            var bali = document.querySelector('#kembalian');

            pembayaran.textContent = 'Rp.' + bayar.toLocaleString();
            bali.textContent = 'Rp.' + kembalian.toLocaleString();

            if (bayar < total) {
                document.getElementById('harga').value = '';
                document.getElementById('pesan').textContent = 'Uang tidak cukup!';
            } else {
                document.getElementById('harga').value = 'Rp.' + kembalian.toLocaleString();
                document.getElementById('pesan').textContent = '';
            }
        }
    </script>
    <script>
        function hitungSubtotal() {
            // Ambil nilai quantity yang baru dimasukkan
            var qtyBaru = parseInt(document.getElementById('qty').value);
            var hargaPerBarang = <?= $data['harga']; ?>;

            // Hitung ulang subtotal berdasarkan harga per barang dan nilai quantity baru
            var subtotal = hargaPerBarang * qtyBaru;

            // Perbarui nilai subtotal dan total secara langsung
            document.getElementById('no').value = 'Rp.' + subtotal.toLocaleString();
            document.getElementById('nama_barang').value = 'Rp.' + subtotal.toLocaleString();
        }
    </script>

    <script>
        var nilai;
        $('.tambah-diskon').on('click', function() {
            nilai = $(this).data('diskon');
            console.log(nilai)
            var total_pembelian = <?= $hasil ?>;
            if (total_pembelian >= 100000) {
                $('#input_diskon').val(nilai);

                // Hitung total setelah diskon
                var total_setelah_diskon = <?= $hasil ?> * (100 - nilai) / 100;
                document.querySelector('#totalDanDiskon').value = total_setelah_diskon
                $('#nama_barang').val('Rp.' + total_setelah_diskon.toLocaleString());
            } else {
                $('#input_diskon').val('');
                $('#nama_barang').val('');
            }
        });
    </script>
</body>

</html>