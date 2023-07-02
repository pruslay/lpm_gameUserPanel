<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
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
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

$filePath = 'config/name.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $variable = $_POST['variable'];
    file_put_contents($filePath, $variable);

}
$variable = '';
if (file_exists($filePath)) {
    $variable = file_get_contents($filePath);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Konfiguracja systemowa - <?php echo $pagename; ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="icon" type="image/x-icon" href="img/logo.png?t=<?php echo filemtime('img/logo.png'); ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
	
.white {
	color: white;
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
	<div class="alert alert-info" role="alert">Konfiguracje MySQL możesz w każdej chwili zmieniać w lokalizacji <strong>config/config.php</strong></div>
	<div class="container">
		<br><h2>Konfiguracja systemowa</h2><br><h1>Wybierz logo</h1>
<body>
    <div class="container">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="logo">Będzie wyświetlane na każdej stronie oraz na karcie w przeglądarce. Musi być w formacie PNG:</label>
                <input type="file" class="form-control-file" id="logo" name="logo" accept="image/png">
            </div>
            <div class="form-group">
                <label for="preview">Podgląd:</label>
                <div id="preview-container" style="width: 30%; margin-bottom: 10px;">
                    <?php
                    $logoPath = "img/logo.png";
                    if (file_exists($logoPath)) {
                        $timestamp = filemtime($logoPath);
                        echo '<img id="preview" src="' . $logoPath . '?t=' . $timestamp . '" alt="Podgląd obrazka" style="max-width: 100%; height: auto;">';
                    }
                    ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Zapisz</button>
        </form>

        <?php
        $logoPath = "img/logo.png";


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_FILES["logo"])) {
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $logoPath)) {
                    echo '<div class="container mt-3">';
                    echo '<div class="alert alert-success" role="alert">Logo zostało zapisane.</div>';
                    echo '</div>';
                } else {
                    echo '<div class="container mt-3">';
                    echo '<div class="alert alert-danger" role="alert">Wystąpił błąd podczas zapisywania logo.</div>';
                    echo '</div>';
                }
            } elseif (isset($_POST["delete_logo"]) && $_POST["delete_logo"] === "1") {
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                    echo '<div class="container mt-3">';
                    echo '<div class="alert alert-success" role="alert">Logo zostało usunięte.</div>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#logo").change(function () {
            readURL(this);
        });
    </script>
	<br><br><br>
	<div class="container">
		<?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo '<div class="alert alert-success">Zaaktualizowano nazwę strony!</div>';
        }
        ?>
        <h1>Edytuj nazwę panelu</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="inputVariable">Będzie to widoczne na wszystkich stronach oraz w stopce również wszystkich stron.</label>
                <input type="text" class="form-control" id="inputVariable" name="variable" placeholder="pruslayPanel v1.0" value="<?php echo $variable; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" onclick="refreshPage()">Zapisz</button>
        </form>
    </div>
	<script>
		$.post('', $('form').serialize(), function() {
			setTimeout(function() {
				location.reload();
			}, 2000);
		});
	}
    </script>
	<br><br><br>
	<h1>Wybierz tło</h1>
	<div class="container">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="logo">Będzie wyświetlane na każdej stronie. Musi być w formacie PNG:</label>
                <input type="file" class="form-control-file" id="bg" name="bg" accept="image/png">
            </div>
            <div class="form-group">
                <label for="preview22">Podgląd:</label>
                <div id="preview2-container" style="width: 30%; margin-bottom: 10px;">
                    <?php
                    $bgPath = "img/bg.png";
                    if (file_exists($bgPath)) {
                        $timestamp = filemtime($bgPath);
                        echo '<img id="preview22" src="' . $bgPath . '?t=' . $timestamp . '" alt="Podgląd obrazka" style="max-width: 100%; height: auto;">';
                    }
                    ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Zapisz</button>
        </form>

        <?php
        $bgPath = "img/bg.png";


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_FILES["bg"])) {
                if (file_exists($bgPath)) {
                    unlink($bgPath);
                }

                if (move_uploaded_file($_FILES["bg"]["tmp_name"], $bgPath)) {
                    echo '<div class="container mt-3">';
                    echo '<div class="alert alert-success" role="alert">Tło zostało zapisane.</div>';
                    echo '</div>';
                } else {
                    echo '<div class="container mt-3">';
                    echo '<div class="alert alert-danger" role="alert">Wystąpił błąd podczas zapisywania tła.</div>';
                    echo '</div>';
                }
            } elseif (isset($_POST["delete_bg"]) && $_POST["delete_bg"] === "1") {
                if (file_exists($bgPath)) {
                    unlink($bgPath);
                    echo '<div class="container mt-3">';
                    echo '<div class="alert alert-success" role="alert">Tło zostało usunięte.</div>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
	<br>
	<h1>Zmień język strony</h1>
	<div class="container">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="logo">Zmieni się na każdej stronie tego panelu.</label>
                <div class="form-group">
					<select class="form-control" id="sel1">
						<option>Polski</option>
					</select>
				</div>
				<button class="btn btn-primary"></span> Zapisz</span></button>
			</div>
	
	<div class="container mt-5">
    <h2>Lista podstron</h2>
    <table class="table">
        <thead>
            <tr>
                <th class="white">Nazwa pliku</th>
                <th class="white">Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $folder = './';
            $ignoredFiles = [
                'addmail.php',
                'panel.php',
				'admin.php',
                'auth.php',
                'changepass.php',
                'config.php',
                'earn.php',
                'inc.php',
                'index.php',
                'logout.php',
                'logoutp.php',
                'module.php',
                'mod.php',
                'newpass.php',
                'panel-ogloszenia.php',
                'profile.php',
                'profile-admin.php',
                'install.php',
				'install2.php',
				'install3.php'
            ];
            $files = glob($folder . '*.php');
            foreach ($files as $file) {
                $fileName = basename($file);
                if (in_array($fileName, $ignoredFiles)) {
                    continue;
                }
                
                echo '<tr>';
				echo '<td>' . $fileName . '</td>';
                echo '<td><a href="' . $fileName . '" class="btn btn-primary btn-sm">Przejdź</a> ';
                echo '<td><a href="?delete=' . urlencode($fileName) . '" class="btn btn-danger btn-sm">Usuń</a></td>';
                echo '</tr>';
            }
            if (isset($_GET['delete'])) {
                $deleteFile = $_GET['delete'];
                if (in_array($deleteFile, $ignoredFiles)) {
                    echo '<div class="alert alert-danger mt-3">Nie można usunąć tego pliku.</div>';
                } else {
                    if (file_exists($folder . $deleteFile) && pathinfo($deleteFile, PATHINFO_EXTENSION) == 'php') {
                        unlink($folder . $deleteFile);
                        echo '<div class="alert alert-success mt-3">Plik został usunięty.</div>';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Nie można usunąć pliku.</div>';
                    }
                }
            }
            ?>
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview2').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#bg").change(function () {
            readURL(this);
        });
    </script>
		<br><br><br>
		<h2>You are running pruslayPanel on version 1.0.</h2>
	<br>
	<button class="btn btn-danger" onclick="window.location.href='module.php'"	><span class="fas fa-caret-left"></span> Powrót</span></button>
	<br><br></div></div><br>
<div class="footer">
	<p><center><font color="white">Made with ❤ by pruslay  |  <?php echo $pagename; ?> 2023</p></font></center>
</div>
</body>
</html>