<?php
$jour = $_GET["date"];
include("config.inc.php");
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn,"edgar");
$req_sql="INSERT into calendrier (jour) VALUE ('$jour')";
mysqli_query($conn, $req_sql);
if(!mysqli_error()){
	include("fonctions.php");
	$retour = convertion($jour);
	mysqli_close($connect);
	header('Location: calendrier_bo.php?mois='.$retour[0].'&an='.$retour[1]);
}else{
	mysqli_close($conn);
	echo 'Echec de l\'enregistrement : <br> '.mysqli_error($conn);
};
?>