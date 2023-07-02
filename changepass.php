<?php
session_start();

include 'config/config.php';

if (!isset($_SESSION['name'])) {
    header("Location: index.html");
    exit();
}

$filePath = 'config/name.txt';

if (file_exists($filePath)) {
    $pagename = file_get_contents($filePath);
}

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];

    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    include 'config/config.php';

    if (mysqli_connect_errno()) {
        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
    }

    $username = $_SESSION['name'];
    $sql = "UPDATE accounts SET password = '$hashedPassword' WHERE username = '$username'";

    if (mysqli_query($con, $sql)) {
        header("Location: index.php?success=Twoje%20hasło%20zostało%20zmienione!%20Zaloguj%20się%20ponownie!");
		exit();
    } else {
        $message = "Błąd podczas aktualizacji hasła: " . mysqli_error($con);
    }
    mysqli_close($con);
}

$logoPath = "img/bg.png";
$timestamp = filemtime($logoPath);
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Zmiana hasła - <?php echo $pagename; ?></title>
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
			<h1>Jesteś zalogowany jako: <?php echo $_SESSION['name']; ?> <strong></strong></h1>
			<img src="https://mc-heads.net/head/<?php echo $_SESSION['name']; ?>/38" alt="">
		<div class="baner">
			<br><iframe frameborder="0" scrolling="no" width="54%" height="75px" src="https://minecraft-lista.pl/serwer/letsplaymc.pl/banner?font_color=ffffff" style="overflow: hidden;"></iframe>
		</div>
		<button class="btn btn-danger" onclick="window.location.href='logout.php'"><span class="fas fa-lock"></span> Wyloguj</button>
		<br><br>
	</div>
	<div class="stats">
		<h1>Zmiana hasła</h1>
		<div class="container">
        <?php if ($message !== ""): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="changepass.php">
            <div class="form-group col-md-6">
                <label>Nowe hasło:</label>
                <input type="password" name="new_password" placeholder="Podaj nowe hasło" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Zmień hasło</button> 
			<button class="btn btn-danger" onclick="window.location.href='profile.php'"	><span class="fas fa-caret-left"></span> Powrót</span></button>
        </form>
		<br>
		</div>
	</div>
	<br>
<div class="footer">
	<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
</div>
  </body>
</html>