<?php


$logoPath = "img/bg.png";
$timestamp = filemtime($logoPath);

$filePath = 'config/name.txt';

if (file_exists($filePath)) {
    $pagename = file_get_contents($filePath);
}

$configPath = 'config/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];
    $usernameadmin = $_POST['usernameadmin'];
	$passwordadmin = $_POST['passwordadmin'];

    file_put_contents($configPath . 'servername.txt', $servername);
    file_put_contents($configPath . 'username.txt', $username);
    file_put_contents($configPath . 'password.txt', $password);
    file_put_contents($configPath . 'dbname.txt', $dbname);
	file_put_contents($configPath . 'usernameadmin.txt', $usernameadmin);


    $con = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_errno()) {
        echo '<div class="alert alert-danger">Błąd połączenia z bazą danych: ' . mysqli_connect_error() . '</div>';
        exit;
    }

    $sql = "CREATE TABLE IF NOT EXISTS accounts (
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255),
        realname VARCHAR(255),
        password VARCHAR(255),
        ip VARCHAR(255),
        lastlogin BIGINT,
        x DOUBLE,
        y DOUBLE,
        z DOUBLE,
        world VARCHAR(255),
        regdate BIGINT,
        regip VARCHAR(255),
        yaw FLOAT,
        pitch FLOAT,
        email VARCHAR(255),
        isLogged SMALLINT,
        hasSession SMALLINT,
        totp VARCHAR(255),
        moderator VARCHAR(255)
    )";
	
	if (!mysqli_query($con, $sql)) {
		echo "Błąd tworzenia tabeli: " . mysqli_error($con);
		exit;
	}
	
	$sql = "INSERT INTO accounts (username) VALUES ('$usernameadmin')";
	if (!mysqli_query($con, $sql)) {
		echo "Błąd dodawania wartości do kolumny 'username': " . mysqli_error($con);
		exit;
	}

	$hashedPassword = password_hash($passwordadmin, PASSWORD_BCRYPT);
	$sql = "UPDATE accounts SET password = '$hashedPassword' WHERE username = '$usernameadmin'";
	if (!mysqli_query($con, $sql)) {
		echo "Błąd aktualizacji wartości w kolumnie 'password': " . mysqli_error($con);
		exit;
		
		
	}

    mysqli_close($con);

}


$servername = '';
$username = '';
$password = '';
$dbname = '';
$usernameadmin = '';

if (file_exists($configPath . 'servername.txt')) {
    $servername = file_get_contents($configPath . 'servername.txt');
}
if (file_exists($configPath . 'username.txt')) {
    $username = file_get_contents($configPath . 'username.txt');
}
if (file_exists($configPath . 'password.txt')) {
    $password = file_get_contents($configPath . 'password.txt');
}
if (file_exists($configPath . 'dbname.txt')) {
    $dbname = file_get_contents($configPath . 'dbname.txt');
}
if (file_exists($configPath . 'usernameadmin.txt')) {
    $dbname = file_get_contents($configPath . 'usernameadmin.txt');
}

	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Instalacja systemu - <?php echo $pagename; ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="icon" type="image/x-icon" href="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<link rel="stylesheet" href="style.css">
		
<style>

body {
  /* Location of the image */
  background-image: url('img/bg.png?t=<?php echo $timestamp; ?>');
  
  /* Image is centered vertically and horizontally at all times */
  background-position: center center;
  
  /* Image doesn't repeat */
  background-repeat: no-repeat;
  
  /* Makes the image fixed in the viewport so that it doesn't move when 
     the content height is greater than the image height */
  background-attachment: fixed;
  
  /* This is what makes the background image rescale based on its container's size */
  background-size: cover;
  
  /* Pick a solid background color that will be displayed while the background image is loading */
  background-color:#464646;
  
  /* SHORTHAND CSS NOTATION
   * background: url(background-photo.jpg) center center cover no-repeat fixed;
   */
}

/* For mobile devices */
@media only screen and (max-width: 767px) {
  body {
    /* The file size of this background image is 93% smaller
     * to improve page load speed on mobile internet connections */
    background-image: url('img/bg.png?t=<?php echo $timestamp; ?>');
  }
	}

</style>
	</head>
	<body>
		<br>
		<br>
		<font color="white"><center>
		<div class="stats">
			<br>
			<font color="white">
			<center><img src="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>" alt="Logo" style="max-width: 15%; height: auto;"></center>
			<h1><?php echo $pagename; ?> - Instalacja</h1>
			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo '<div class="alert alert-success">pruslayPanel w wersji 1.0 został pomyślnie zainstalowany!.<a href="index.php"> Zaloguj się</a></div>';
			}
			?>
			<div class="container">
			<h1>Podaj preferencje do bazy danych.</h1>
				<form method="post" action="">
					<div class="form-group">
						<label for="inputServername">Nazwa serwera:</label>
						<input type="text" class="form-control" id="inputServername" name="servername" placeholder="Nazwa serwera bazy danych MySQL" value="<?php echo $servername; ?>" required>
					</div>
					<div class="form-group">
						<label for="inputUsername">Nazwa użytkownika:</label>
						<input type="text" class="form-control" id="inputUsername" name="username" placeholder="Nazwa użytkownika do bazy danych MySQL" value="<?php echo $username; ?>" required>
					</div>
					<div class="form-group">
						<label for="inputPassword">Hasło:</label>
						<input type="password" class="form-control" id="inputPassword" name="password" placeholder="Hasło do bazy danych MySQL" value="<?php echo $password; ?>" required>
					</div>
					<div class="form-group">
						<label for="inputDBName">Nazwa bazy:</label>
						<input type="text" class="form-control" id="inputDBName" name="dbname" placeholder="Nazwa bazy danych MySQL" value="<?php echo $dbname; ?>" required>
					</div>
					<br><br><br>
					<div class="form-group">
						<label for="inputUsernameAdmin">Nazwa użytkownika administratora:</label>
						<input type="text" class="form-control" id="inputUsernameAdmin" name="usernameadmin" placeholder="Nazwa użytkownika, jaką chcesz aby logować się jako administrator" value="<?php echo $usernameadmin; ?>" required>
					</div>
					<div class="form-group">
						<label for="inputPasswordAdmin">Hasło administratora:</label>
						<input type="text" class="form-control" id="inputPasswordAdmin" name="passwordadmin" placeholder="Hasło, jakie chcesz aby logować się jako administrator" value="<?php echo $passwordadmin; ?>" required>
					</div>
					<button type="submit" class="btn btn-primary">Kontynuuj</button>
				</form>
    </div>
			<br><br>
			</font>
		</div>
		<div class="footer">
			<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
		</div>
	</body>
</html> 