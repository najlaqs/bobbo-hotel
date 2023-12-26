<?php
include 'koneksi.php'; // import koneksi.php yang berisikan koneksi ke database reservasihotel

if ($_SERVER["REQUEST_METHOD"] == "POST") //membuat kondisi ketika server request method berupa post
{
    $nama_awal = $_POST["nama_awal"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="nama_awal"
    $nama_akhir = $_POST["nama_akhir"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="nama_akhir"
    $user_name = $_POST["user_name"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="user_name"
    $nomor_telepon = $_POST["nomor_telephon"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="nomor_telephon"
    $alamat_email = $_POST["almt_email"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="almt_email"
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // pembuatan variabel untuk mengambil data dari input dengan atribut name="password" 
    // dan penggunaan fungsi(password_hash) untuk sensor password pada database 
    $level = "user"; // pembuatan variabel yang berisikan string user 

    // pembuatan query untuk INSERT(menambahkan) data ke atribut tabel user, dimana VALUES(berisikan) data yang sudah diambil sebelumnya pada variabel ($nama_awal, $nama_akhir, $username, $nomor_telepon, $alamat_email, $password, $level)
    $query = "INSERT INTO user (nama_awal, nama_akhir, username, nomor_telepon, alamat_email, password, level) 
            VALUES ('$nama_awal', '$nama_akhir', '$user_name', '$nomor_telepon', '$alamat_email', '$password', '$level')";

    //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
    $hasil_tambah = mysqli_query($koneksi, $query);

    //membuat variabel yang berisikan fungsi untuk mengambil hasil dari setiap baris data
    $count = mysqli_affected_rows($koneksi);

    //membuat fungsi ketika variabel($count) menghasilkan satu baris data atau tidak
    if ($count == 1) {
        header("Location: login.php"); //ketika menghasilkan satu baris data maka akan diarahkan atau redirect ke halaman login
    } else {
        header("Location: register.php"); //ketika tidak menghasilkan satu baris data maka akan tetap di halaman
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="a">
    <div class="rowregis">
        <img src="asset/hoteldubai.jpg" alt="tampilan regis" class="tampilanregis">
        <div class="tengah">
            <h1 class="textregis">Register</h1>
            <form action="" method="POST" class="column">
                <div class="rowregis">
                    <input type="text" name="nama_awal" placeholder="First Name">
                    <input type="text" name="nama_akhir" placeholder="Last Name" style="margin-left: 30px;">
                </div>
                <div class="column">
                    <input type="text" name="user_name" placeholder="USERNAME">
                    <input type="text" name="nomor_telephon" placeholder="PHONE">
                    <input type="email" name="almt_email" placeholder="EMAIL ADDRESS">
                    <input type="password" name="password" placeholder="PASSWORD">
                </div>
                <button type="submit" class="btn-regis" name="simpan">SIGN UP</button>
            </form>
        </div>
    </div>
</body>

</html>