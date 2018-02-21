<?php
	setcookie("authentification",$_POST["pseudo"]);
	header('Location: index.php');
	exit();
?>