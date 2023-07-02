<?php

$logoPath = "img/bg.png";
$timestamp = filemtime($logoPath);
	
$filePath = 'config/name.txt';

if (file_exists($filePath)) {
    $pagename = file_get_contents($filePath);
}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nie posiadasz uprawnień!</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="icon" type="image/x-icon" href="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
		<script src="https://cdn.rawgit.com/leonardosnt/mc-player-counter/1.1.0/dist/mc-player-counter.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
	<font color="white">
	<div class="stats"><br><br>
	<h1>Nie posiadasz uprawnień do przeglądania tej strony.</h1><br>
	<center><button class="btn btn-danger" onclick="window.location.href='profile.php'"><span class="fa fa-rotate-left"></span> Powrót</button></center><br>
		</div>
		<div class="footer">
			<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
		</div>
	</body>
</html>
<!-- Step 7: Create an HTML form with an input text field for the new password -->