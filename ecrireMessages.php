<?php
	include('confi.php');
	$sql = "INSERT INTO message (id_message, recepteur, emetteur, object, text, lu) VALUES(NULL, ".$_GET['recepteur'].",".$_GET['login'].",".$_GET['objet'].",".$_GET['texte'].", 1)";
	$results = mysqli_query($link,$query);
?>