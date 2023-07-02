<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
include 'config/config.php';


$name = $_SESSION['name'];
$stmt = $con->prepare('SELECT password, totp FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

session_start();

	
	
$filePath = 'config/name.txt';

if (file_exists($filePath)) {
    $pagename = file_get_contents($filePath);
}
	
	
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Dodaj adres e-mail - <?php echo $pagename; ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="icon" type="image/x-icon" href="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<link rel="stylesheet" href="style.css">
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
			<h1>Jesteś zalogowany jako: <?php echo $_SESSION['name']; ?> <strong>(Administrator)</strong></h1>
			<img src="https://mc-heads.net/head/<?php echo $_SESSION['name']; ?>/38" alt="">
		<div class="baner">
			<br><iframe frameborder="0" scrolling="no" width="54%" height="75px" src="https://minecraft-lista.pl/serwer/letsplaymc.pl/banner?font_color=ffffff" style="overflow: hidden;"></iframe>
		</div>
		<button class="btn btn-danger" onclick="window.location.href='logout.php'"><span class="fas fa-lock"></span> Wyloguj</button>
		<br><br>
	</div>
	<div class="stats">
		<h1>Dodaj adres e-mail</h1>
		<div class="alert alert-dark" role="alert">
		  Dzięki podpięciu maila łatwiej odzyskasz konto w przypadku straty lub zapomnianego hasła.
		</div>
		<div class="col-md-4 mb-3">
		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$email = $_POST["email"];
				if (!$con) {
				    die("Connection failed: " . mysqli_connect_error());
				}
				$sql = "UPDATE accounts SET email='$email' WHERE username='$name'";
				if (mysqli_query($con, $sql)) {
				    echo "<div class='alert alert-success'>Twój adres e-mail został dodany poprawnie!</div>";
				} else {
				    echo "<div class='alert alert-danger'>Nie można dodać adresu: " . mysqli_error($con) . "</div>";
				}
				mysqli_close($con);
			}
		?>
		<form method="post">
			<div class="col-md-8 mb-3">
				<div class="form-group">
					<label for="email">Adres e-mail:</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Podaj adres e-mail" required>
				</div>
				<div class="btn-toolbar">
					<button type="submit" class="btn btn-info"><span class="fas fa-edit"></span> Zmień</span></button>
					<button class="btn btn-danger" onclick="window.location.href='profile.php'"	><span class="fas fa-caret-left"></span> Powrót</span></button>
				</div>
			</div>
		</form><br>
	</div>
	<br>
		<div class="footer">
			<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
		</div>
  </body>
</html>