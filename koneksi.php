<?php
//membuat variabel yang berisikan fungsi(mysqli_connect) untuk koneksi ke database reservasihotel
$koneksi = mysqli_connect("localhost", "root", "", "reservasihotel");
if (session_status() == PHP_SESSION_NONE) { //membuat kondisi untuk mengetahui status session
    session_start(); //mengeksekusi session pada server
  }
// Check connection
if (!$koneksi) { //membuat kondisi ketika variabel yang berisi fungsi untuk koneksi database tidak tehubung
die("Connection failed: " . mysqli_connect_error()); //menampilkan pesan error 
}
?>