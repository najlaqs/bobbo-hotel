<?php
include 'koneksi.php'; // import koneksi.php yang berisikan koneksi ke database reservasihotel

$checkinDate = $_GET["checkin"] ?? null; //pembuatan variabel untuk get data checkin jika ada data, maka nilai variabel diatur sebagai null
$checkoutDate = $_GET["checkout"] ?? null; //pembuatan variabel untuk get data checkout jika ada data, maka nilai variabel diatur sebagai null

//pembuatan variabel yang berisikan apakah terdapat sesi atau tidak
$IdUser = isset($_SESSION['Id_user']) ? $_SESSION['Id_user'] : ''; 
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$userPhone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';

$query = "SELECT * FROM room"; //pembuatan variabel yang berisikan select tabel room 
$result = mysqli_query($koneksi, $query);

$statusQuery = "SELECT * FROM status"; // Replace 'nama_tabel_status' with your actual table name
$statusResult = mysqli_query($koneksi, $statusQuery); //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)


if ($_SERVER["REQUEST_METHOD"] == "POST") { //membuat kondisi ketika server request method berupa post
    $IdUser = $_POST['Id_user']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="typ"
    $room = $_POST['room']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="typ"
    $checkinDate = $_POST['checkin']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="typ"
    $checkoutDate = $_POST['checkout']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="typ"
    $totalPrice = $_POST['totalPrice']; // pembuatan variabel untuk mengambil data dari input dengan atribut name="typ"
    $status = '1'; // pembuatan variabel yang berisikan string user 

    // pembuatan query untuk INSERT(menambahkan) data ke atribut tabel user, dimana VALUES(berisikan) data yang sudah diambil sebelumnya pada variabel ($nama_awal, $nama_akhir, $username, $nomor_telepon, $alamat_email, $password, $level)
    $insertQuery = "INSERT INTO reservasi (Id_user, Id_kamar, tanggal_Check_in, tanggal_Check_out, total_harga, Id_status)
                    VALUES ('$IdUser', '$room', '$checkinDate', '$checkoutDate', '$totalPrice', '$status')";

    //membuat variabel yang berisikan fungsi untuk menjalankan/eksekusi query dan menghubungkannya ke database($koneksi)
    $hasil_tambah = mysqli_query($koneksi, $insertQuery);

    //membuat variabel yang berisikan fungsi untuk mengambil hasil dari baris data
    $count = mysqli_affected_rows($koneksi);

    //membuat fungsi ketika variabel($count) menghasilkan satu baris data atau tidak
    if ($count == 1) {
        header("Location: index.php"); //ketika menghasilkan satu baris data maka akan diarahkan atau redirect ke halaman login
    } else {
        header("Location: room.php"); //ketika tidak menghasilkan satu baris data maka akan tetap di halaman
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

<body>
    <div class="pageroom">
        <h1>ROOM</h1>
    </div>
    <div class="row2">
            <?php
            $roomPrices = array(); // mendeklarasikan variabel $roomPrices sebagai array kosong
            // pembuatan looping baris data dari variabel $result yang dimana nantinya setiap hasil perulangan disimpan ke variabel $row
            while ($row = mysqli_fetch_assoc($result)) {
                $roomPrices[$row['tipe_kamar']] = $row['harga']; // menyimpan nilai harga ke dalam array $roomPrices[$row['tipe_kamar']]
                $roomId[$row['tipe_kamar']] = $row['Id_kamar']; // menyimpan nilai Id_kamar ke dalam array $roomId[$row['tipe_kamar']]

                echo '<div class="em">';
                echo '<img src="asset/' . $row['foto'] . '" alt="' . $row['tipe_kamar'] . '" class="pRoomTT">'; //menampilkan hasil perulangan data foto dan tipe_kamar dari atribut tabel room serta pemanggilan foto dari asset
                echo '<h3>' . $row['tipe_kamar'] . '</h3>'; //menampilkan hasil perulangan data tipe_kamar dari atribut tabel room
                echo '<h2>Rp. ' . number_format($row['harga'], 0, ',', '.') . ' IDR/night</h2>'; //menampilkan hasil perulangan data total_harga dari atribut tabel reservasi serta penggunaan fungsi format angka
                echo '<a href="#"><button class="btn-PROOMTT" onclick="showModal(\'' . $row['tipe_kamar'] . '\', ' . $row['Id_kamar'] . ')">Reserve</button></a>'; //button yang membawa data dari perulangan berupa data tipe_kamat, dan Id kamar
                echo '</div>';
            }

            mysqli_free_result($result); // untuk clear result
            mysqli_close($koneksi); // untuk menutup koneksi ke database
            ?>
    </div>
    <!-- Modal Room -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <!-- membuat elemen yang yang ketika diklik menjalankan fungsi closeModal() untuk menutup modal -->
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Reservasi</h2>
            <form action="" method="POST" onsubmit="showPaymentModal(); return false;">
                <input type="hidden" id="Id_user" name="Id_user" value="<?php echo $IdUser; //menampilkan hasil data dari variabel IdUser berupa data Id_user ?>">
                <div class="form-group">
                    <label for="fname">Nama Lengkap</label>
                    <input type="text" id="fname" name="fname" value="<?php echo $userName; //menampilkan hasil data dari variabel userName berupa data username ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php echo $userEmail; //menampilkan hasil data dari variabel userEmail berupa data alamat_email ?>">
                </div>
                <div class="form-group">
                    <label for="telp">Nomor Telepon</label>
                    <input type="text" id="telp" name="telp" value="<?php echo $userPhone; //menampilkan hasil data dari variabel userPhone berupa data nomor_telepon ?>">
                </div>
                <div class="form-group">
                    <label for="room">Room</label>
                    <input type="text" id="room" name="roomm" value="">
                    <input type="hidden" id="roommId" name="room" value="">
                </div>
                <div class="form-group">
                    <label for="checkin">Check In</label>
                    <input type="date" id="checkin" name="checkin" value="<?php echo $checkinDate; //menampilkan hasil data dari variabel checkinDate berupa data tanggal_Check_in ?>">
                </div>
                <div class="form-group">
                    <label for="checkout">Check Out</label>
                    <input type="date" id="checkout" name="checkout" value="<?php echo $checkoutDate; //menampilkan hasil data dari variabel checkoutDate berupa data tanggal_Check_out ?>">
                </div>
                <div class="form-group">
                    <label for="totalPrice">Total Harga</label>
                    <input type="text" id="totalPrice" name="totalPrice" value="">
                </div>
                <div class="form-group" style="text-align: center;">
                    <button type="submit" class="btn-submit">Reservasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Payment -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <!-- membuat elemen yang yang ketika diklik menjalankan fungsi closePaymentmModal() untuk menutup modal -->
            <span class="close" onclick="closePaymentModal()">&times;</span>
            <h2>See you soon,<?php echo $userName; //menampilkan hasil data dari variabel userName berupa data username ?></h2>
            <p>Your reservations for <?php echo $checkinDate; //menampilkan hasil data dari variabel checkinDate berupa data tanggal_Check_in ?> has been confirmed</p>
            <p>Please make payments via transfer in the following number: </p>
            <p><b> BCA : 345678389</b></p>
            <hr>
            <p>Guest Name: <?php echo $userName; ?></p>
            <p>Room Plan: <span id="inforoom"></span></p>
            <hr>
            <p>Amount: Rp. <span id="paymentAmount"></span></p>
            <form action="" method="POST">
                <input type="hidden" id="Id_user" name="Id_user" value="<?php echo $IdUser; //menampilkan hasil data dari variabel IdUser berupa data Id_user ?>">
                <input type="hidden" id="fname" name="fname" value="<?php echo $userName; //menampilkan hasil data dari variabel userName berupa data username ?>">
                <input type="hidden" id="email" name="email" value="<?php echo $userEmail; //menampilkan hasil data dari variabel userEmail berupa data alamat_email ?>">
                <input type="hidden" id="telp" name="telp" value="<?php echo $userPhone; //menampilkan hasil data dari variabel userPhone berupa data nomor_telepon ?>">
                <input type="hidden" id="roommId1" name="room" value="">
                <input type="hidden" id="checkin" name="checkin" value="<?php echo $checkinDate; //menampilkan hasil data dari variabel checkinDate berupa data tanggal_Check_in ?>">
                <input type="hidden" id="checkout" name="checkout" value="<?php echo $checkoutDate; //menampilkan hasil data dari variabel checkoutDate berupa data tanggal_Check_out ?>">
                <input type="hidden" id="totalPrice1" name="totalPrice" value="">
                <button type="submit" class="btn-submit" name="submitReservation">Reservasi</button>
            </form>
        </div>

    </div>
    <script>
        var modal = document.getElementById("myModal");
        var selectedRoom = ""; // Variabel untuk menyimpan informasi room yang dipilih
        var roomPrices = <?php echo json_encode($roomPrices); ?>; // Harga kamar dari PHP
        var roomId = <?php echo json_encode($roomId); ?>; // Harga kamar dari PHP

        // Fungsi untuk menampilkan modal dengan informasi room yang dipilih
        function showModal(roomInfo, roomId) {
            selectedRoom = roomInfo; // informasi room yang dipilih
            modal.style.display = "block";
            document.getElementById("room").value = selectedRoom; // Menampilkan informasi room pada form
            var inforoom = document.getElementById("room").value;
            document.getElementById("inforoom").innerText = inforoom;
            updateTotalPrice(); // mengeksekusi fungsi updateTotalPrice() 
        }

        // Fungsi untuk memperbarui total harga berdasarkan kamar yang dipilih dan lama hari reservasi
        function updateTotalPrice() {
            var checkinDate = new Date(document.getElementById("checkin").value);
            var checkoutDate = new Date(document.getElementById("checkout").value);

            // Hitung jumlah hari antara check-in dan check-out
            var numberOfDays = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24));

            // Hasil harga kamar yang dipilih
            var selectedRoomPrice = roomPrices[selectedRoom];
            var selectedRoomId = roomId[selectedRoom];

            // Hitung total harga
            var totalPrice = numberOfDays * selectedRoomPrice;

            // Menampilkan total harga dalam form
            document.getElementById("totalPrice").value = totalPrice;
            document.getElementById("totalPrice1").value = totalPrice;
            document.getElementById("roommId").value = selectedRoomId;
            document.getElementById("roommId1").value = selectedRoomId;
        }

        // Menutup modal ketika user mengklik tombol tutup
        function closeModal() {
            modal.style.display = "none";
        }

        // Menutup modal ketika user mengklik di luar modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Tambahkan event listener untuk pembaruan total harga saat nilai check-in atau check-out berubah
        document.getElementById("checkin").addEventListener("change", updateTotalPrice);
        document.getElementById("checkout").addEventListener("change", updateTotalPrice);

        function showPaymentModal() {
            closeModal(); // Close myModal

            var paymentAmount = document.getElementById("totalPrice").value;
            document.getElementById("paymentAmount").innerText = paymentAmount;

            var paymentModal = document.getElementById("paymentModal");
            paymentModal.style.display = "block";
        }

        function closePaymentModal() {
            var paymentModal = document.getElementById("paymentModal");
            paymentModal.style.display = "none";

            window.location.href = "index.php";
        }
    </script>
</body>

</html>