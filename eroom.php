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

$Rid = $_GET['Id_kamar']; // pembuatan variabel bernama $Rid yang berisikan GET Id_kamar

if ($_SERVER["REQUEST_METHOD"] == "POST") { //membuat kondisi ketika server request method berupa post
    $typ = $_POST['typ']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="typ"
    $desc = $_POST['desc']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="desc"
    $phto = $_POST['phto']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="phto"
    $prc = $_POST['prc']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="prc"

    // pembuatan query untuk update data tipe_kamar, deskripsi_kamar, foto, harga sesuai dengan data yang diambil dari inputan
    $updateQuery = "UPDATE room SET tipe_kamar = '$typ', deskripsi_kamar = '$desc', foto = '$phto', harga = '$prc' WHERE Id_kamar='$Rid'";

    //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
    $updateResult = mysqli_query($koneksi, $updateQuery);

    // pembuatan kondisi jika hasil eksekusi variabel $updateResult tidak sama atau tidak sesuai
    if (!$updateResult) {
        die("Update query failed: " . mysqli_error($koneksi)); //jika iya akan memunculkan pesan error
    }
    header("Location: room-admin.php"); //jika tidak akan diarahkan ke admin.php
}

$roomQuery = "SELECT * FROM room WHERE Id_kamar = $Rid"; //pembuatan variabel yang berisikan select tabel room dimana atribut Id_kamar bernilai sama dengan nilai variabel $Rid 
$roomResult = mysqli_query($koneksi, $roomQuery); //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
$roomData = mysqli_fetch_assoc($roomResult); //membuat variabel yang berisikan fungsi untuk mengambil hasil query sebagai array
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
        <h1>EDIT RESERVATION</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="typ">Type Room</label>
                <input type="text" id="typ" name="typ" value="<?php echo $roomData['tipe_kamar']; //menampilkan hasil data dari variabel roomData berupa data tipe_kamar ?>"> 
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <input type="text" id="desc" name="desc" value="<?php echo $roomData['deskripsi_kamar']; //menampilkan hasil data dari variabel roomData berupa data deskripsi_kamar ?>">
            </div>
            <div class="form-group">
                <label for="phto">Photo</label>
                <input type="hidden" id="phto" name="phto" value="<?php echo $roomData['foto']; //menampilkan hasil data dari variabel roomData berupa data foto ?>">
                <!-- pembuatan input untuk foto yang dimana ketika ada perubahan(onChage) akan eksekusi fungsi updateCurrentPhoto -->
                <input type="file" id="currentPhoto" name="currentPhoto" onchange="updateCurrentPhoto(this)"> 
            </div>
            <div class="form-group">
                <label for="prc">Price</label>
                <input type="text" id="prc" name="prc" value="<?php echo $roomData['harga']; //menampilkan hasil data dari variabel roomData berupa data tipe_kamar ?>">
            </div>
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn-submit">Submit</button>
            </div>
        </form>
        <script>
            function updateCurrentPhoto(input) { //pembuatan fungsi untuk update foto terbaru
                var currentPhotoInput = document.getElementById('phto'); // pembuatan variabel yang berisikan get id pada atribut inputan (id="phto")
                var newPhotoName = input.value.split('\\').pop(); // pembuatan variabel untuk mendapatkan nama file foto
                currentPhotoInput.value = newPhotoName; //mengatur nilai variabel currentPhotoInput menjadi nilai yang diperoleh variabel newPhotoName 
            }
        </script>
    </div>

</html>