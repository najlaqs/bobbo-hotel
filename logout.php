<?php
session_start(); //memulai atau melanjutkan sesi yang sudah ada
session_destroy(); //untuk destroy semua data yang terkait dengan sesi
header("Location: login.php"); // lalu akan diarahkan ke login.php
?>