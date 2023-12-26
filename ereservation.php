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
    $loginButton = '<a href="login.php"><button class="btn-lgn">Login</button></a>';
}

$Rid = $_GET['Id_reservasi']; // pembuatan variabel bernama $Rid yang berisikan GET Id_reservasi

if ($_SERVER["REQUEST_METHOD"] == "POST") { //membuat kondisi ketika server request method berupa post
    if (isset($_POST['status'])) {  // pembuatan kondisi ketika melakukan post status
        $statusId = $_POST['status']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="status"

        // pembuatan query untuk update data Id_status sesuai id yang di get sebelumnya
        $updateQuery = "UPDATE reservasi SET Id_status = $statusId WHERE Id_reservasi='$Rid'";

        //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
        $updateResult = mysqli_query($koneksi, $updateQuery);

        // pembuatan kondisi jika hasil eksekusi variabel $updateResult tidak sama atau tidak sesuai
        if (!$updateResult) {
            die("Update query failed: " . mysqli_error($koneksi)); //jika iya akan memunculkan pesan error
        }
        header("Location: admin.php"); //jika tidak akan diarahkan ke admin.php
    }
}

$statusQuery = "SELECT * FROM status"; //pembuatan variabel yang berisikan select tabel status
$statusResult = mysqli_query($koneksi, $statusQuery); //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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
        <h1>EDIT ROOM</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" style="width: 50%;">
                    <?php
                    // pembuatan looping baris data dari variabel $statusResult yang dimana nantinya setiap hasil perulangan disimpan ke variabel $statusRow
                    while ($statusRow = mysqli_fetch_assoc($statusResult)) {
                        echo '<option value="' . $statusRow['Id_status'] . '">' . $statusRow['nama'] . '</option>'; //menampilkan hasil perulangan data nama staus dari atribut tabel status
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-submit">Update Status</button>
            </div>
        </form>
    </div>

</html>