<?php
include 'koneksi.php';

$loginButton = '<a href="logout.php"><button class="btn-lgn">Logout</button></a>';

if (empty($_SESSION["Id_user"])) {
    $loginButton = '<a href="login.php"><button class="btn-lgn">Login</button></a>';
} else {
    $uid = $_SESSION["Id_user"];
    $qry = "SELECT * FROM user WHERE Id_user = $uid";
    $res = mysqli_query($koneksi, $qry);
    
    if (mysqli_num_rows($res) > 0) {
        $udata = mysqli_fetch_array($res);
        $_SESSION["Id_user"] = $udata["Id_user"];
        $_SESSION["username"] = $udata["username"];
        $_SESSION["email"] = $udata["alamat_email"];
        $_SESSION["phone"] = $udata["nomor_telepon"];
    }  
}

//create
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkinDate = $_POST["checkin_date"];
    $checkoutDate = $_POST["checkout_date"];
    header("Location: room.php?checkin=$checkinDate&checkout=$checkoutDate");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bobbo hotel</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/080951bfbd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header class="header-user">
        <nav class="nav-user">
            <div class="lg">
                <img src="asset/logofix.png" alt="logo Four Points Surabaya" class="logo">
            </div>
            <div class="menu">
                <a href="#home" class="nav-link">Home</a>
                <a href="#room-suites" class="nav-link">Room & Suites</a>
                <a href="#facilities" class="nav-link">Facilities</a>
                <a href="#promotion" class="nav-link">Promotion</a>
                <?php echo $loginButton; ?>
            </div>
        </nav>
    </header>
    <main>
        <section id="home">
            <img src="asset/hoteldubai.jpg" alt="tampilan hotel" class="tampilanhotel">
            <div class="card">
                <form class="inp" method="POST" id="availabilityForm">
                    <div class="form-group-index">
                        <label for="check-in">Check-In</label>
                        <div class="input-container">
                            <i class="fa-solid fa-calendar"></i>
                            <input type="date" name="checkin_date">
                        </div>
                    </div>
                    <div class="form-group-index">
                        <label for="check-out">Check-Out</label>
                        <div class="input-container">
                            <i class="fa-solid fa-calendar"></i>
                            <input type="date" name="checkout_date">
                        </div>
                    </div>
                    <button type="submit" class="btn-booknow">Check Availability</button>
                </form>
            </div>
            <div>
                <h1 class="welcome">WELCOME</h1>
                <div class="grid-container">
                    <div class="grid-item">
                        Hotel Bintang 5 Surabaya.
                        Bobbo hotel merupakan salah satu hotel dengan harga terjangkau
                        Namun,kualitasnya tetap nomor 1 diIndonesia. 
                        Bobbo hotel ini terhubung langsung ke pusat perbelanjaan
                        ,serta mendapatkan beragam keunggulan menarik seperti,
                        kamar bersih, tempat ibadah, kolam renang, dan lain-lainnya.
                        Jelajahi setiap fasilitas hotel
                        yang moderen, nikmati berbagai hidangan
                        khas Nusantara di restoran hotel kami,
                        Djaman Doeloe Resto & Bar, serta
                        bersantai sejenak sambil menikmati
                        minuman dingin di Soiree Rooftop Bar.
                    </div>
                    <div class="grid-item"><img src="asset/fourpoint1.jpeg" alt="fotowelcome" class="fotoh1">
                    </div>
                </div>
            </div>
        </section>
        <section id="room-suites">
            <div>
                <h1 class="roomh1">ROOM</h1>
                <img src="asset/Suite premium .png" alt="fotoroom" class="room">
                <div class="cardroom">
                    <h2 class="text1">Premium Suites</h2>
                    <h3 class="text2">Premium Suite terluas dengan luas kamar 64 sqm, terdiri dari kamar tidur dan ruang
                        tamu yang terpisah
                    </h3>
                    <h3 class="text3">Mulai dari</h3>
                    <h2 class="text4">5.000.000</h2>
                    <center><a href="#home"><button class="btn-bk">Book Now</button></a></center>
                </div>
            </div>
        </section>
        <section id="facilities">
            <div>
                <h1 class="facilities">FACILITIES</h1>
            </div>
            <div class="row">
                <img src="asset/resto.png" alt="resto" class="resto">
                <img src="asset/gym1.jpeg" alt="gym" class="gym">
                <img src="asset/bar.png" alt="bar" class="bar">
            </div>
            <img src="asset/kolamrenanghotel1.jpeg" alt="kolamrenang" class="kolamrenang">
            <div class="cardfacilities">
                <h2 class="textfalities">FACILITIES & LAYANAN HOTEL </h2>
                <ul>
                    <li>Ruang pertemuan dan Acara</li>
                    <li>Kolam renang</li>
                    <li>Soiree Rooftop Bar</li>
                    <li>Akses langsung Mall</li>
                    <li>Layanan Valet</li>
                    <li>Standar kebersihan Marriott International</li>
                    <li>Sanitasi dengan UV Light</li>
                </ul>
            </div>
        </section>
        <section id="promotion">
            <div>
                <h1 class="promotion">PROMOTION</h1>
            </div>
            <div class="row">
                <img src="asset/p1.png" alt="new year" class="newyear">
                <img src="asset/p2.png" alt="jelajah rasa nusantara" class="jelajahrasa">
            </div>
            <div class="row">
                <div class="cardpromotion">
                    <h2 class="card1">New Year Stay Over</h2>
                    <p class="cardp">
                        Sambutan tahun baru 2024 dengan pesta musik dan gala dinner yang meriah.
                        Inilah yang anda dapatkan selama menginap:
                    </p>
                    <ul>
                        <li>Sarapan untuk maksimal 2 orang</li>
                        <li>1 kali Old & New 2024 with Vina Panduwinata Gala Dinner dan Live Music Show di The Westin
                            Grand</li>
                        <li>Ballroom untuk 2 orang</li>
                        <li>Akses internet berkecepatan tinggi gratis</li>
                    </ul>
                </div>
                <div class="cardpromotion2">
                    <h2 class="card2">Jelajah Rasa Nusantara </h2>
                    <p class="cardp2">
                        Berkumpul bersama teman, keluarga, dan kolega Anda di Djaman Doeloe Resto & Bar dan cicipi
                        berbagai
                        cita rasa masakan khas nusantara yang lezat hasil olahan kreasi dari tim kuliner kami yang
                        berbakat.
                    </p>
                    <ul>
                        <li>Buffet Dinner, Kamis - Sabtu pukul 18.00-21.00</li>
                        <li>Brunch Buffet, Minggu pukul 12.00-15.00</li>
                    </ul>
                    <p>
                        Rp. 185.000 net/orang
                    </p>
                </div>
            </div>
        </section>
    </main>
    <script>
        /*navbar aktif*/
        let navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach(navLink => {
            navLink.addEventListener("click", () => {
                let currentActiveLink = document.querySelector(".nav-link.active");
                if (currentActiveLink) {
                    currentActiveLink.classList.remove("active");
                }
                navLink.classList.add("active");
            });
        });
    </script>

</body>

</html>