<?php
include 'koneksi.php'; // import koneksi.php yang berisikan koneksi ke database reservasihotel

// pengecekan apakah session dari user memiliki level admin, jika session user tidak memiliki level admin maka akan diarahkan ke index.php
if ($_SESSION["level"] !== "admin") {
    header("Location: index.php");
}

// pembuatan variabel bernama $loginButton yang berisikan button Logout
$loginButton = '<a href="logout.php"><button class="btn-lgn-admin">Logout</button></a>';


// pengecekan apakah terdapat session, jika empty session (sesi tidak ada) maka akan memunculkan button login
if (empty($_SESSION["Id_user"])) {
    $loginButton = '<a href="login.php"><button class="btn-lgn">Login</button></a>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { //membuat kondisi ketika server request method berupa post
    $tipe_kamar = $_POST["typ"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="typ"
    $deskripsi_kamar = $_POST["desc"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="desc"
    $foto = $_POST["phto"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="phto"
    $harga = $_POST["prc"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="prc"

    // pembuatan query untuk INSERT(menambahkan) data ke atribut tabel room, dimana VALUES(berisikan) data yang sudah diambil sebelumnya pada variabel ($tipe_kamar, $deskripsi_kamar, $foto, $harga)
    $query = "INSERT INTO room (tipe_kamar, deskripsi_kamar, foto, harga) 
            VALUES ('$tipe_kamar', '$deskripsi_kamar', '$foto', '$harga')";

    //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
    $hasil_tambah = mysqli_query($koneksi, $query);

    //membuat variabel yang berisikan fungsi untuk mengambil hasil dari baris data
    $count = mysqli_affected_rows($koneksi);

    //membuat fungsi ketika variabel($count) menghasilkan satu baris data atau tidak
    if ($count == 1) {
        header("Location: room-admin.php"); //ketika menghasilkan satu baris data maka akan diarahkan atau redirect ke halaman login
    } else {
        header("Location: croom.php"); //ketika tidak menghasilkan satu baris data maka akan tetap di halaman
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
    <script src="https://kit.fontawesome.com/080951bfbd.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="sidenav">
        <h1 class="textadmin">HELLO ADMIN</h1>
        <a href="admin.php">Reservation</a>
        <a href="room-admin.php">Room</a>
        <?php
            echo $loginButton; //pemanggilan variabel $loginButton yang berisikan button sesuai dengan kondisi session 
        ?>
    </div>

    <div class="main">
        <h2> CREATE ROOM</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="typ">Type Room</label>
                <input type="text" id="typ" name="typ" placeholder="Input Type Room">
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <input type="text" id="desc" name="desc" placeholder="Input Description">
            </div>
            <div class="form-group">
                <label for="phto">Photo</label>
                <input type="file" id="phto" name="phto" placeholder="Input Photo">
            </div>
            <div class="form-group">
                <label for="prc">Price</label>
                <input type="text" id="prc" name="prc" placeholder="Input Price">
            </div>
    </div>
    <div class="form-group" style="text-align: center;">
        <button type="submit" class="btn-submit" name="simpan">Submit</button>
    </div>
    </form>
    </div>
</body>

</html>