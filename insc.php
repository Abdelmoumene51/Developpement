<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Document sans titre</title>
</head>

<body>
<?php
include('include/confi.php');

$nom=$_POST['nom'];
$adresse=$_POST['adresse'];
$prenom=$_POST['prenom'];
$tele=$_POST['tele'];
$mail=$_POST['mail'];
$mobile=$_POST['mobile'];
$societe=$_POST['societe'];
$civilite=$_POST['civilite'];
$id=$_POST['id'];
$password=$_POST['password'];
$date_naiss=$_POST['date_naiss'];

if(!empty($_POST['adresse']) || !empty($_POST['nom']) || !empty($_POST['prenom']) || !empty($_POST['tele']) || !empty($_POST['date_naiss'])|| !empty($_POST['mail']) || !empty($_POST['societe']) || !empty($_POST['civilite']) || !empty($_POST['mobile']) || !empty($_POST['id']) || !empty($_POST['password'])){
	$requete= "select * from cliente where societe='$societe'";
	$resultat=mysqli_query($link, $requete) or die ("echec de l'execution de la requete<br>." .mysql_error());

		$requete="INSERT INTO cliente(societe,civilite,nom,prenom,adresse,tele,mobile,mail,date_naiss,id,password) VALUES('$societe','$civilite','$nom','$prenom','$adresse','$tele','$mobile','$mail','$date_naiss','$id','$password') ";
		$reponse=mysqli_query($link, $requete);
		?><SCRIPT LANGUAGE="JAVASCRIPT"> alert("inscription effectuée avec succes!");</SCRIPT><?php
		echo '<meta http-equiv="refresh" content="0; URL=inscription.php">';
		
}
?>
</body>
</html>
