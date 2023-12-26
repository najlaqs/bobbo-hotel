<?php
include 'koneksi.php'; // import koneksi.php yang berisikan koneksi ke database reservasihotel

// pembuatan kondisi ketika melakukan get Id_kamar
if (isset($_GET['Id_kamar'])) {
    $roomId = $_GET['Id_kamar']; // pembuatan variabel yang berisikan get data Id_kamar 

    // pembuatan query untuk hapus(delete) data sesuai id yang di get sebelumnya
    $deleteQuery = "DELETE FROM room WHERE Id_kamar = $roomId";

    //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
    $deleteResult = mysqli_query($koneksi, $deleteQuery);

    // pembuatan kondisi ketika variabel $deleteResult dieksekusi
    if ($deleteResult) {
        header("Location: room-admin.php"); //jika dieksekusi akan diarahkan ke room-admin.php
    } else {
        echo "Error deleting reservation: " . mysqli_error($koneksi); //jika tidak akan memunculkan pesan error
    }
}
?>