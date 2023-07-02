<?php
session_start();

$pathAdmin = 'config/usernameadmin.txt';

if (file_exists($pathAdmin)) {
    $admin = file_get_contents($pathAdmin);
}

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
include 'config/config.php';

if (isset($_SESSION['name']) && $_SESSION['name'] == $admin) {
  header("Location: profile-admin.php");
  exit;
}


$name = $_SESSION['name'];
$stmt = $con->prepare('SELECT password, totp FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

$filePath = 'config/name.txt';

if (file_exists($filePath)) {
    $pagename = file_get_contents($filePath);
}



// DANE Z BAZY DANYCH SĄ PONIŻEJ. WYSTARCZY ŻE ZMIENISZ PONIŻSZE PRZYKŁADY NA WŁASNE. PORADNIK JEST DOSTĘPNY NA KANALE PRUSLAY:
// https://www.youtube.com/channel/UC2c6xj_F3UQg3JZOCFWizZw


	
	
// ZMIEŃ TE DANE POD SWÓJ PLUGIN! JEŻELI MASZ OPENWALLET ZOSTAW TAK JAK JEST, JEŻELI NIE SKONFIGURUJ POD SIEBIE!
// $sql1 = "SELECT balance FROM wallet_data WHERE name = '$name'";
// $result1 = mysqli_query($con, $sql1);

// while ($row1 = mysqli_fetch_assoc($result1)) {
// END
	
	
// ZMIEŃ TE DANE POD SWÓJ PLUGIN! JEŻELI MASZ AUTHME ZOSTAW TAK JAK JEST, JEŻELI NIE SKONFIGURUJ POD SIEBIE!
$sql2 = "SELECT email FROM accounts WHERE username = '$name'";
$result2 = mysqli_query($con, $sql2);

while ($row2 = mysqli_fetch_assoc($result2)) {

$sql3 = "SELECT ip FROM accounts WHERE username = '$name'";
$result3 = mysqli_query($con, $sql3);

while ($row3 = mysqli_fetch_assoc($result3)) {
// END


// ZAPRASZAM DO PORADNIKA NA YOUTUBE, TAM JEST LEPIEJ OPISANE.
// DLA OSÓB, KTÓRE CHCĄ ZROBIĆ TO BEZ PORADNIKA MOŻNA TUTAJ, JEST OPISANE.


// $sql4 = "SELECT (wybieramy jaką kolumnę chcemy wybrać) FROM (wybieramy z której tabeli chcemy wybrać te kolumny) WHERE **username = '$name'"** (jest to opcjonalne, jeżeli chcemy pobrać dane tylko dla zalogowanego użytkownika);
// $result4 = mysqli_query($con, $sql4);

// (WSZYSTKO DALEJ ZOSTAWIAMY TAK JAK JEST, OCZYWIŚCIE DODAJĄC KOLEJNY NUMER DO KAŻDEJ ZMIENNEJ $)

// while ($row4 = mysqli_fetch_assoc($result4)) {


// KONIEC :)

$logoPath = "img/bg.png";
$timestamp = filemtime($logoPath);
	
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profil - <?php echo $pagename; ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="icon" type="image/x-icon" href="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<link rel="stylesheet" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style>
body {
  background-image: url('img/bg.png?t=<?php echo $timestamp; ?>');
  background-position: center center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
  background-color:#464646;
}

@media only screen and (max-width: 767px) {
  body {
    background-image: url('img/bg.png?t=<?php echo $timestamp; ?>');
  }
	}

</style>
  </head>
  <body>
    <center><font color="#FFF">
	<div class="login">
		<img src="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>" alt="Logo" style="max-width: 15%; height: auto;">
			<span class="count bg-success"></span>
			<h1>Jesteś zalogowany jako: <?php echo $_SESSION['name']; ?> <strong>(Gracz)</strong></h1>
			<img src="https://mc-heads.net/head/<?php echo $_SESSION['name']; ?>/38" alt="">
		<div class="baner">
			<br><iframe frameborder="0" scrolling="no" width="54%" height="75px" src="https://minecraft-lista.pl/serwer/letsplaymc.pl/banner?font_color=ffffff" style="overflow: hidden;"></iframe>
		</div>
		<button class="btn btn-danger" onclick="window.location.href='logout.php'"><span class="fas fa-lock"></span> Wyloguj</button>
		<br><br>
	</div>
	<div class="stats">
		<h1>Statystyki gracza</h1>
		<br>
		<div class="ranga"><br>
		
			<!-- Twoje dane z bazy danych (są u góry pliku) -->
		
			<span><i class="fas fa-wallet"></i> Pieniądze w twoim portfelu: <strong><?php echo $row1['balance']; ?> PLN</strong></span>
			
			<!-- Powyżej db.php -->
			
				<br><br>
				<button class="btn btn-dark" onclick="window.location.href='https://vishop.pl/shop/292'"><span class="fas fa-shopping-cart"></span> Doładuj portfel</button>
			<font color="#191c24"><p>.</p></font>
		</div><br>
		
		<!-- Twoje dane z bazy danych (są u góry pliku) -->
		
		<h5>Podpięty email:<strong> <?php echo $row2['email']; ?></strong> <button class="btn btn-dark" onclick="window.location.href='addmail.php'"><span class="fas fa-link"></span> Połącz e-mail</button></h5>
		<h5>IP: <strong><?php echo $row3['ip']; ?></strong></h5><font color="red">IP widoczne jest tylko dla administracji!</font><br><br>
		
		<!-- Powyżej db.php -->
		
		<div class="btn-toolbar">
			<button class="btn btn-info" onclick="window.location.href='changepass.php'"><span class="fas fa-lock-open"></span> Zmień hasło</button>
			<button class="btn btn-info" onclick="window.location.href='earn.php'"><span class="fas fa-gift"></span> Zarabiaj pieniądze do portfela! <span class="badge badge-warning">$$$</span></button>
		</div><br><br>
		<?php } ?>
		<?php } ?>
	</div>
		<div class="footer">
			<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
		</div>
  </body>
</html>