<?php
	include('confi.php');
	$recherche = $_GET["recherche"];
	$l="SELECT DISTINCT objet.Ville, objet.id_objj,
			objet.adressePostale
			FROM objet
			WHERE objet.nom LIKE '".$recherche."'";
	if($e=mysqli_query($link,$l))
	{
		$result = ((string)mysqli_num_rows($e)).';';
		$i = 0;
		while($donnee=mysqli_fetch_array($e)){
			$result = $result.$donnee['adressePostale'].'+'.$donnee['Ville'].';';
		}
		echo $result;
	}
?>