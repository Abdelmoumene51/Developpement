<?php
	include('confi.php');
	$sql = "INSERT INTO `message` (`id_message`, `recepteur`, `emetteur`, `object`, `text`, `lu`) VALUES('','".$_GET['recepteur']."','".$_GET['login']."','".$_GET['objet']."','".$_GET['texte']."', 1)";
	echo $sql;
	$results = mysqli_query($link,$sql);
?>