<?php

// NIC TU NIE ZMIENIAJ! TO NIE JEST PLIK KONFIGURACYJNY!

$configPath = 'config/';

$servername = file_get_contents($configPath . 'servername.txt');
$username = file_get_contents($configPath . 'username.txt');
$password = file_get_contents($configPath . 'password.txt');
$dbname = file_get_contents($configPath . 'dbname.txt');

$con = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    header("Location: install.php");
	exit();
}

// NIC POWYŻEJ NIE ZMIENIAJ!

?>