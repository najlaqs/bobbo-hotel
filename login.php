<?php
include 'koneksi.php'; // import koneksi.php yang berisikan koneksi ke database reservasihotel

if ($_SERVER["REQUEST_METHOD"] == "POST") { //membuat kondisi ketika server request method berupa post
  $alamat_email = $_POST["alamat_email"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="alamat_email"
  $password = $_POST["password"]; // pembuatan variabel untuk mengambil data dari input dengan atribut name="password"

  // pembuatan query untuk Select tabel user dimana atribut alamat email bernilai sama dengan nilai variabel $alamat_email 
  $query = "SELECT * FROM user WHERE alamat_email = '$alamat_email'";
  $result = $koneksi->query($query); //pembuatan variabel untuk eksekusi query

  if ($result->num_rows > 0) { // pengecekan apakah hasil dari eksekusi query ($result) menghasilkan satu atau lebih dari satu baris data
    $row = $result->fetch_assoc(); // pembuatan variabel yang berisikan hasil baris data

    if (password_verify($password, $row["password"])) { //membuat kondisi untuk memeriksa apakah password yang diinputkan sesuai 
        $_SESSION["Id_user"] = $row["Id_user"]; //jika sesuai maka menyimpan data Id_user ke dalam variabel $row
        $_SESSION["username"] = $row["username"]; //jika sesuai maka menyimpan data username ke dalam variabel $row
        $_SESSION["level"] = $row["level"]; //jika sesuai maka menyimpan data level ke dalam variabel $row

        if ($row["level"] == 'admin') { //membuat kondisi apakah data level yang didapatkan memiliki nilai admin
            header("Location: admin.php"); //jika iya akan diarahkan ke admin.php
        } else {
            header("Location: index.php"); //jika tidak akan diarahkan ke index.php
        }
    } else { //jika tidak sesuai maka akan memunculkan alert berupa pesan Incorrect Email or Password
        echo "<script> alert('Incorrect Email or Password'); </script>";
    }
} else {  //jika tidak menghasilkan satu atau lebih baris data maka akan memunculkan alert berupa pesan User Not Registered
    echo "<script> alert('User Not Registered'); </script>";
}
}

$koneksi->close(); // untuk menutup koneksi ke database
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
  <img src="asset/hoteldubai.jpg" alt="tampilanhotel" class="tampilanlogin">
  <div class="cardlogin">
    <h1>Login</h1>
    <form action="" method="POST" class="login">
      <input type="email" name="alamat_email" placeholder="Email ID">
      <input type="password" name="password" placeholder="Password">
      <center>
      <button type="submit" class="btn-login" name="submit">Login</button>
      </center>
    </form>
  </div>
  <div class="login-bwh">
    <a href="regis.php">Don’t have an account? Register</a>
  </div>
</body>

</html>