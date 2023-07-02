<?php
session_start();

include 'config/config.php';

if (!isset($_POST['username'], $_POST['password'])) {
	header('Location: index.php');
	exit();
}

if ($con->connect_error) {
    header("Location: install.php");
    exit();
}

$name = $_SESSION['name'];

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password);
		$stmt->fetch();
		if (password_verify($_POST['password'], $password)) {
			session_regenerate_id();
			$_SESSION['loggedin'] = true;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;

			header('Location: profile.php');
			exit();
		} else {
			header('Location: index.php?error=Niepoprawne%20hasło%20lub%20nazwa%20użytkownika.');
			exit();
		}
	} else {
		header('Location: index.php?error=Niepoprawne%20hasło%20lub%20nazwa%20użytkownika.');
		exit();
	}

	$stmt->close();
}
?>
