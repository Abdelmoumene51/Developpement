<?php
	include('confi.php');
	if(isset($_GET['debutloc']) && isset($_GET['finloc']))
	{
		$getLoc = "SELECT locataire.id_locataire FROM locataire WHERE locataire.login = '".$_GET['login']."'";
		$results = mysqli_query($link,$getLoc);
		if($results)
		{
			$donnee=mysqli_fetch_array($results);
			$sql = "INSERT INTO `location` (`id_location`, `datedebut`, `datefin`, `id_objj`, `id_locataire`, `validite`) VALUES (NULL, '".$_GET['debutloc']."', '".$_GET['finloc']."', '".$_GET['idObj']."', '".$donnee['id_locataire']."', '0')";
			$results = mysqli_query($link,$sql);
		}
	}
?>