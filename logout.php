<?php
session_start();
session_destroy();
header('Location: index.php?success=Zostałeś%20wylogowany!');
?>