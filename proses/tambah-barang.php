<?php
include '../conn.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];

    $query_barang = "SELECT * FROM barang WHERE kode_barang = '$kode_barang'";
    $result_barang = mysqli_query($conn, $query_barang);

    if ($result_barang && mysqli_num_rows($result_barang) > 0) {
        $row_barang = mysqli_fetch_assoc($result_barang);
        $harga = $row_barang['harga'];
        $diskon = $row_barang['diskon'];
        $total_harga = $harga * (100 - $diskon) / 100;

        $query_check = "SELECT * FROM keranjang WHERE kode_produk='$kode_barang'";
        $result_check = mysqli_query($conn, $query_check);

        if ($result_check && mysqli_num_rows($result_check) > 0) {
            $row_check = mysqli_fetch_assoc($result_check);
            $id = $row_check["id"];
            $qty = $row_check["qty"] + 1;
            $query_update = "UPDATE keranjang SET qty = '$qty' WHERE id='$id'";
            $result_update = mysqli_query($conn, $query_update);

            if ($result_update) {
                header("Location: ../index.php");
                exit();
            } else {
                echo "Gagal memperbarui data";
            }
        } else {
            $query_insert = "INSERT INTO keranjang (kode_produk, nama_produk, harga, qty, diskon, total) VALUES ('$kode_barang', '{$row_barang['nama_barang']}', $harga, 1, $diskon, $total_harga)";
            $result_insert = mysqli_query($conn, $query_insert);
            if ($result_insert) {
                header("Location: ../index.php");
                exit();
            } else {
                echo "Gagal menambah data";
            }
        }
    } else {
        echo "Barang tidak ditemukan.";
    }
}
?>