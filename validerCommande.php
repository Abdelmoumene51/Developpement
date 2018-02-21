<?php
	include('confi.php');
	if(isset($_GET['idObj']) && isset($_GET['debutloc']) && isset($_GET['finloc']))
	{
		$sql = "UPDATE `location` SET `validite` = '1' WHERE `location`.`id_objj` = '".$_GET['idObj']."'AND `location`.`datedebut` = '".$_GET['debutloc']."'AND `location`.`datefin` = '".$_GET['finloc']."'";
		$results = mysqli_query($link,$sql);
	}
?>