<?php
include 'koneksi.php'; // import koneksi.php yang berisikan koneksi ke database reservasihotel

// pengecekan apakah session dari user memiliki level admin, jika session user tidak memiliki level admin maka akan diarahkan ke index.php
if ($_SESSION["level"] !== "admin") {
    header("Location: index.php");
    exit();
}

// pembuatan variabel bernama $loginButton yang berisikan button Logout
$loginButton = '<a href="logout.php"><button class="btn-lgn-admin">Logout</button></a>';


// pengecekan apakah terdapat session, jika empty session (sesi tidak ada) maka akan memunculkan button login
if (empty($_SESSION["Id_user"])) {
    $loginButton = '<a href="login.php"><button class="btn-lgn-admin">Login</button></a>';
}

$uid = $_SESSION["Id_user"]; // pembuatan variabel bernama $uid yang berisikan session berupa id user
$qry = "SELECT * FROM user WHERE Id_user = $uid"; //pembuatan variabel untuk Select tabel user dimana atribut Id_user bernilai sama dengan nilai variabel $Id_user 
$res = mysqli_query($koneksi, $qry); //pembuatan variabel $res yang mengeksekusi query dari $qry ke database($koneksi)
if (mysqli_num_rows($res) > 0) { // pengecekan apakah hasil dari eksekusi query ($res) menghasilkan satu atau lebih dari satu baris data
    $udata = mysqli_fetch_array($res); //pengambilan baris data dari hasil query ($res) untuk diubah menjadi array
    $_SESSION["Id_user"] = $udata["Id_user"]; //Setelah mengambil baris data, nilai (Id_user) yang diperoleh dari array disimpan dalam variabel $_SESSION["Id_user"]
    $_SESSION["username"] = $udata["username"]; //Setelah mengambil baris data, nilai (username) yang diperoleh dari array disimpan dalam variabel $_SESSION["username"]
}

//pembuatan variabel berisikan select tabel reservasi untuk digabungkan(JOIN) dengan tabel seperti user(username), room(tipe_kamar), dan status(nama)
$reservationQuery = "SELECT reservasi.*, user.username, room.tipe_kamar, status.nama
                     FROM reservasi
                     JOIN user ON reservasi.Id_user = user.Id_user
                     JOIN room ON reservasi.Id_kamar = room.Id_kamar
                     JOIN status ON reservasi.Id_status = status.Id_status";
$reservationResult = mysqli_query($koneksi, $reservationQuery); //pembuatan variabel $reservationResult yang mengeksekusi query dari $reservationQuery ke database($koneksi)
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
        <h1>RESERVATION</h1>
        <table class="styled-table">
            <tr>
                <th>Guest</th>
                <th>Room</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            // pembuatan looping baris data dari variabel $reservationResult yang dimana nantinya setiap hasil perulangan disimpan ke variabel $row
            while ($row = mysqli_fetch_assoc($reservationResult)) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>"; //menampilkan hasil perulangan data username dari atribut tabel reservasi
                echo "<td>{$row['tipe_kamar']}</td>"; //menampilkan hasil perulangan data tipe_kamar dari atribut tabel reservasi
                echo "<td>{$row['tanggal_Check_in']}</td>"; //menampilkan hasil perulangan data tanggal_Check_in dari atribut tabel reservasi
                echo "<td>{$row['tanggal_Check_out']}</td>"; //menampilkan hasil perulangan data tanggal_Check_out dari atribut tabel reservasi
                echo '<td>Rp. ' . number_format($row['total_harga'], 0, ',', '.') . '</td>'; //menampilkan hasil perulangan data total_harga dari atribut tabel reservasi serta penggunaan fungsi format angka
                echo "<td>{$row['nama']}</td>"; //menampilkan hasil perulangan data nama dari atribut tabel reservasi
                echo "<td>
                        <a href='ereservation.php?Id_reservasi={$row['Id_reservasi']}'><button class='fa-solid fa-pen-to-square'></button></a>      
                     </td>"; //pembuatan button action untuk edit reservasi
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>