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

$roomQuery = "SELECT * FROM room"; //pembuatan variabel yang berisikan select tabel room 
$roomResult = mysqli_query($koneksi, $roomQuery);  //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
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
        <div class="room-admin">
            <h1>RESERVATION</h1>
            <a href="croom.php"><button class="btn-croom"><i class="fa-solid fa-plus"></i>
                    <b>Add Room</b>
                </button></a>
        </div>
        <table class="styled-table">
            <tr>
                <th>Type Room</th>
                <th>Decription</th>
                <th>Photo</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
            // pembuatan looping baris data dari variabel $roomResult yang dimana nantinya setiap hasil perulangan disimpan ke variabel $row
            while ($row = mysqli_fetch_assoc($roomResult)) {
                echo "<tr>";
                echo "<td>{$row['tipe_kamar']}</td>"; //menampilkan hasil perulangan data tipe_kamar dari atribut tabel room
                echo "<td>{$row['deskripsi_kamar']}</td>"; //menampilkan hasil perulangan data deskripsi_kamar dari atribut tabel room
                $imageURL = 'asset/' . $row['foto'];
                echo "<td><img src='$imageURL' alt='Room Photo' style='width: 100px; height: 100px;'></td>"; //menampilkan hasil perulangan data foto dari atribut tabel room serta pemanggilan foto dari asset
                echo '<td>Rp. ' . number_format($row['harga'], 0, ',', '.') . '</td>'; //menampilkan hasil perulangan data total_harga dari atribut tabel reservasi serta penggunaan fungsi format angka
                echo "<td>
                    <a href='eroom.php?Id_kamar={$row['Id_kamar']}'><button class='fa-solid fa-pen-to-square'></button></a>
                    <a href='droom.php?Id_kamar={$row['Id_kamar']}'><button class='fa-solid fa-trash'></button></a>
                  </td>";  //pembuatan button action untuk edit dan delete room
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>