<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>boite mail</title>
</head>

<body>
<?php
session_start ();
include('confi.php');
$idOK=false;
$id =($_POST['id']);
$password =($_POST['password']); 

 
if (empty($_POST['id']) || empty($_POST['password']))  {
?>
<SCRIPT LANGUAGE="JAVASCRIPT"> alert(" Veuillez vérifier le formulaire d'authentification !! ");</SCRIPT> 
<?php
echo'<meta http-equiv="refresh" content="0; URL=authentification.php">';
?>
 <?php
}else{
$query = "SELECT login,mdp FROM locataire where login='$id' and mdp='$password'";
$results = mysqli_query($link, $query) or die ("echec de l'exécution de la requête<br>."  . mysql_error());
   if(mysqli_num_rows($results) > 0){
   $data = mysqli_fetch_object($results);
   $idOK=true;
   }else  { 
   ?>
<SCRIPT LANGUAGE="JAVASCRIPT"> alert(" Ce client est non reconu dans le système !! ");</SCRIPT> 
<?php
echo'<meta http-equiv="refresh" content="0; URL=authentification.php">';
?>
 <?php
   
   
   }
}
if($idOK){
  
  
   $_SESSION['id']=$data->id;
   $_SESSION['password']=$data->password;
   header("location:http://localhost/projet708/boite mail.php?login=$id");
   
  // echo '<meta http-equiv="refresh" content="0;URL=boite mail.php?login=''">';
}
?>

</body>
</html>
