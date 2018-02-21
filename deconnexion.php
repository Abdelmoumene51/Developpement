<?php
	setcookie('authentification', NULL, -1);
	header('Location: index.php');
	exit();
?>