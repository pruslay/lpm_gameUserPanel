<?php

include 'config/config.php';

$logoPath = "img/bg.png";
$timestamp = filemtime($logoPath);

$filePath = 'config/name.txt';

if (file_exists($filePath)) {
    $pagename = file_get_contents($filePath);
}

if (empty($servername) || empty($username) || empty($password) || empty($dbname)) {
    header("Location: install.php");
    exit();
}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Zaloguj się - <?php echo $pagename; ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="icon" type="image/x-icon" href="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<link rel="stylesheet" href="login.css">
		
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
		<font color="white">
		<div class="login">
			<br>
			<font color="white">
			<center><img src="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>" alt="Logo" style="max-width: 15%; height: auto;"></center>
			<h1><?php echo $pagename; ?></h1>
			<?php
			if (isset($_GET['success'])) {
				$alertMessage = $_GET['success'];
				echo '<center><div class="alert alert-success">' . $alertMessage . '</div></center>';
			}
			
			if (isset($_GET['error'])) {
				$alertMessage = $_GET['error'];
				echo '<center><div class="alert alert-danger">' . $alertMessage . '</div></center>';
			}
			?>
			<form action="auth.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Login" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Hasło" id="password" required>
				<center><p>Dodatkowe informacje dla graczy na serwerze.</p></center>
				<button class="btn btn-info" onclick="window.location.href='auth.php'"><span class="fas fa-lock"></span> Zaloguj</button>
			</form>
			<br>
			<center><a href="blank.php">Link do innej strony.</a></center>
			<br>
			</font>
		</div>
		<div class="footer">
			<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
		</div>
	</body>
</html> 