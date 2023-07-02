<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
include 'config/config.php';

$pathAdmin = 'config/usernameadmin.txt';

if (file_exists($pathAdmin)) {
    $admin = file_get_contents($pathAdmin);
}

if (!isset($_SESSION['name']) && $_SESSION['name'] != $admin) {
  header("Location: profile.php");
  exit;
}

$filePath = 'config/name.txt';

if (file_exists($filePath)) {
    $pagename = file_get_contents($filePath);
}


$name = $_SESSION['name'];
$stmt = $con->prepare('SELECT password, totp FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>




<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Panel administratora - <?php echo $pagename; ?></title>
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
			<h1>Jesteś zalogowany jako: <?php echo $_SESSION['name']; ?> <strong>(Administrator)</strong></h1>
			<img src="https://mc-heads.net/head/<?php echo $_SESSION['name']; ?>/38" alt="">
		<div class="baner">
			<br><iframe frameborder="0" scrolling="no" width="54%" height="75px" src="https://minecraft-lista.pl/serwer/letsplaymc.pl/banner?font_color=ffffff" style="overflow: hidden;"></iframe>
		</div>
		<button class="btn btn-danger" onclick="window.location.href='logout.php'"><span class="fas fa-lock"></span> Wyloguj</button>
		<br><br>
	</div>
	<div class="stats">
	<br>
	<div class="container"><br>
        <h2>Panel administratora</h2><br>
		<button class="btn btn-danger" onclick="window.location.href='module.php'"	><span class="fas fa-caret-left"></span> Powrót</span></button>
        <?php
			include 'config/config.php';
			if ($con->connect_error) {
				die("Nie udało się połączyć z bazą danych: " . $con->connect_error);
			}

			function generateRandomPassword($length = 8) {
				$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_';
				$password = '';
				
				for ($i = 0; $i < $length; $i++) {
					$index = rand(0, strlen($characters) - 1);
					$password .= $characters[$index];
				}
				
				return $password;
			}

			function hashPassword($password) {
				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
				return $hashedPassword;
			}

			function resetujHaslo($username) {
				global $con;

				$newPassword = generateRandomPassword(8);
				$hashedPassword = hashPassword($newPassword);

				$sql = "UPDATE accounts SET password = '$hashedPassword' WHERE username = '$username'";

				if ($con->query($sql) === TRUE) {
					echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Zresetowano hasło użytkownika $username. Nowe hasło: <strong>$newPassword</strong></div>";
				} else {
					echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Błąd podczas resetowania hasła użytkownika $username: " . $con->error . "</div>";
				}
			}

			function zmienEmail($username, $newEmail) {
				global $con;

				$sql = "UPDATE accounts SET email = '$newEmail' WHERE username = '$username'";

				if ($con->query($sql) === TRUE) {
					echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Zmieniono adres e-mail użytkownika $username na $newEmail.</div>";
				} else {
					echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Błąd podczas zmiany adresu e-mail użytkownika $username: " . $con->error . "</div>";
				}
			}

			function dodajPLN($username, $newMoney) {
				global $con;

				$sql = "UPDATE wallet_data SET balance = '$newMoney' WHERE name = '$username'";

				if ($con->query($sql) === TRUE) {
					echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Nadano graczowi $username $newMoney PLN.</div>";
				} else {
					echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Błąd podczas nadawania PLN graczowi $username: " . $con->error . "</div>";
				}
			}

			$sql = "SELECT username, email FROM accounts";
			$result = $con->query($sql);

			if ($result->num_rows > 0) {
				echo "<table class='table'>";
				echo "<tr><th>Nick</th><th>E-mail</th><th>Portfel</th><th>Akcje</th></tr>";

				while ($row = $result->fetch_assoc()) {
					$username = $row["username"];
					$email = $row["email"];
					
					$sqlWallet = "SELECT balance FROM wallet_data WHERE name = '$username'";
					$resultWallet = $con->query($sqlWallet);
					$balance = ($resultWallet->num_rows > 0) ? $resultWallet->fetch_assoc()['balance'] : 0;


					echo "<tr>";
					echo "<td><white>$username</td>";
					echo "<td><white>$email</td>";
					echo "<td><white>$balance PLN</td>";
					echo "<td>";
					
					echo "<form method='POST'><input type='hidden' name='username' value='$username'><button class='btn btn-info' type='submit' name='resetuj'>Resetuj hasło</button></form><br>";
					
					echo "<form method='POST'><input type='hidden' name='username' value='$username'><br><div class='input-group'><input type='email' class='form-control' name='newEmail' placeholder='Nowy e-mail'><button class='btn btn-primary' type='submit' name='zmienEmail'>Zmień e-mail</button></div></form><br>";
					
					echo "<form method='POST'><input type='hidden' name='username' value='$username'><br><div class='input-group'><input type='number' class='form-control' name='newMoney' placeholder='Ilość kasy'><button class='btn btn-primary' type='submit' name='dodajKase'>Ustaw</button></div></form><br>";


					echo "</td>";
					echo "</tr>";
					echo "<br>";
				}

				echo "</table>";
			} else {
				echo "<div class='alert alert-info' role='alert'>Brak użytkowników w bazie danych.</div>";
			}

			if (isset($_POST['resetuj'])) {
				$username = $_POST['username'];
				resetujHaslo($username);
			}
			if (isset($_POST['zmienEmail'])) {
				$username = $_POST['username'];
				$newEmail = $_POST['newEmail'];
				zmienEmail($username, $newEmail);
			}
			if (isset($_POST['dodajKase'])) {
				$username = $_POST['username'];
				$newMoney = $_POST['newMoney'];
				dodajPLN($username, $newMoney);
			}
			$con->close();
			?>
            </tbody>
        </table>
	</div></div><br>
<div class="footer">
	<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
</div>
  </body>
</html>