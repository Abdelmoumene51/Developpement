<html>
<head>
<title>Planning</title>
<link href="calendar.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/fontAwesome.css">
        <link rel="stylesheet" href="css/hero-slider.css">
        <link rel="stylesheet" href="css/tooplate-style.css">
	
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="bootstrap-3.2.0-dist/js/bootstrap.js"></script>
</head>
<body>
<div class="col-md-12">
<?php
include("fonctions.php");
// recuperatio du jous, mois, et année actuel
$jour_actuel = date("j", time());
$mois_actuel = date("m", time());
$an_actuel = date("Y", time());
$jour = $jour_actuel;
$mois = $mois_actuel;
$an= $an_actuel;

if(isset($_GET["mois"]))
{
	$jour = $_GET['jour'];
	$mois=$_GET['mois'];
	$an=$_GET['an'];
}
$jour_prec = $jour;
$mois_prec = $mois;
$an_prec = $an;
$jour_suivant = $jour;
$mois_suivant = $mois;
$an_suivant = $an;
if(!checkdate($mois,$jour,$an))
{
	$jour = $jour_actuel;
	$mois = $mois_actuel;
	$an= $an_actuel;
}
$jour_prec = $jour - 1;
if(!checkdate($mois,$jour_prec,$an))
{
	$mois_prec = $mois - 1;
	$jour_prec = 31;
	if($mois_prec == 0)
	{
		$mois_prec = 12;
		$an_prec = $an - 1;
	}
	while(!checkdate($mois_prec,$jour_prec,$an))
	{
		$jour_prec--;
	}
}
$jour_suivant = $jour + 1;
if(!checkdate($mois,$jour_suivant,$an))
{
	$jour_suivant = 1;
	$mois_suivant = $mois + 1;
	if($mois + 1 > 12)
	{
		$mois_suivant = 1;
		$an_suivant = $an + 1;
	}
}

//affichage du mois et de l'année en french
$mois_de_annee = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre");
$mois_en_clair = $mois_de_annee[$mois - 1];
for($j = 1; $j < 32; $j++){
$tab_jours[$j] = (bool)false;
}
// connexion à la bdd
include("confi.php");
$connexion = mysqli_connect("localhost", "root", "");
mysqli_select_db($connexion, "edgar");
$sql = "SELECT location.datedebut, location.datefin, locataire.login, objet.prelevement 
FROM location,locataire,objet 
WHERE location.id_objj = '".$_GET['idobjet']."'
AND locataire.id_locataire = location.id_locataire 
AND objet.id_objj = location.id_objj";
?>
<br />

<table width="100%" align="center" border="0" class="tab_journalier">
	<tr>
		<td width="60%" height="51" colspan="7">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td class="date"><div><?php echo $jour," ",$mois_en_clair," ", $an; ?></div></td>
					<div id="actionsCal">
						<td>
							<a href="journalier.php?mois=<?php echo $mois_prec.'&idobjet='.$_GET['idobjet'].'&jour='.$jour_prec; ?>&an=<?php echo $an_prec; ?>">
						  <div align="right"><img border="0" src="img/prec.gif" /></div></a>
					  </td>
						<td>
							<a href="journalier.php?mois=<?php echo $mois_suivant.'&idobjet='.$_GET['idobjet'].'&jour='.$jour_suivant; ?>&an=<?php echo $an_suivant; ?>">
						  <div><img border="0" src="img/suiv.gif" /></div>
						  </a>					
					  </td>
				  </div>
				</tr>
		  </table>
	  </td>
	</tr>
	<tr class="jours">
		<td width="12%">0h</td>
		<td width="12%">3h</td>
		<td width="13%">6h</td>
		<td width="13%">9h</td>
		<td width="13%">12h</td>
		<td width="13%">15h</td>
		<td width="12%">18h</td>
		<td width="12%">21h</td>
	</tr>
	<tr align="center">
	<table width="100%"><tr>
		<?php
		$resultat;
		$passed = false;
		// Lorsqu'il y a une location sur le jour sélectionné, contient l'heure de début et de fin
		$heureDebutLocation = 0;
		$heureFinLocation = 0;
		//login,debut,fin;login,debut,fin
		$str_heures = "";
		$table_occupation = array();
		for($i=0 ; $i<24 ; $i++)
		{
			$table_occupation[$i] = 0;
		}
		if($resultat=mysqli_query($connexion,$sql))
		{
			while($donnee=mysqli_fetch_array($resultat))
			{
				if($donnee['prelevement'] == "h")
				{
					$dateSelectionnee = strtotime($an_actuel."-".$mois_actuel."-".$jour_actuel." 00:00:00");
					if(isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['an']))
					{
						$dateSelectionnee = strtotime($_GET['an']."-".$_GET['mois']."-".$_GET['jour']." 00:00:00");
					}
					$dateDebut = date('Y-m-d H:i:s',strtotime($donnee['datedebut']));
					$dateFin = date('Y-m-d H:i:s',strtotime($donnee['datefin']));
					$tempDate = date('Y-m-d',strtotime($donnee['datedebut']));
					$tempDate = intval(strtotime(date('Y-m-d',strtotime($dateDebut))));
					while($tempDate < intval(strtotime($dateFin)))
					{
						//echo($tempDate." ; ".intval(strtotime($dateFin))." ; ".$dateSelectionnee."<br>");
						if($tempDate >= $dateSelectionnee && $tempDate < ($dateSelectionnee+86400))
						{
							for($i=0 ; $i<24 ; $i++)
							{
								//echo($tempDate." ; ".strtotime($dateDebut)."<br>");
								if($tempDate < intval(strtotime($dateFin)) && $tempDate > intval(strtotime($dateDebut)))
								{
									//echo($tempDate." ; ".intval(strtotime($dateFin))."<br>");
									$table_occupation[$i] = 1;
									//echo('<td height="20px" bgcolor="red"></td>');
									$heureFinLocation = $i;
								}
								else
								{
									//echo('<td height="20px" bgcolor="green"></td>');
									if($table_occupation[$i] != 1)
									{
										$table_occupation[$i] = 0;
									}
									if($heureFinLocation == 0)
									{
										$heureDebutLocation = $i;
									}
								}
								$tempDate += 3600;
							}
							$passed = true;
							$tempDate = intval(strtotime($dateFin));
						}
						$tempDate += 86400;
					}
					if($passed == true)
					{
						
						if(intval(date('d',strtotime($donnee['datedebut']))) == intval(date('d',$dateSelectionnee)))
						{
							$heureDebutLocation = strval(date('H:i',strtotime($donnee['datedebut'])));
						}
						else
						{
							$heureDebutLocation .= ':00';
						}
						if(intval(date('d',strtotime($donnee['datefin']))) == intval(date('d',$dateSelectionnee)))
						{
							$heureFinLocation = strval(date('H:i',strtotime($donnee['datefin'])));
						}
						else
						{
							if($heureFinLocation == 23)
							{
								$heureFinLocation .= ':59';
							}
							else
							{
								$heureFinLocation .= ':00';
							}
						}
						$str_heures .= ($donnee['login'].",".strval($heureDebutLocation).",".strval($heureFinLocation).";");
					}
				}
				$heureDebutLocation = 0;
				$heureFinLocation = 0;
				$passed = false;
			}
			if($str_heures == "")
			{
				for($i=0 ; $i<24 ; $i++)
				{
					echo('<td height="20px" bgcolor="green"></td>');
				}
			}
			else
			{
				$str_heures = substr($str_heures,0,strlen($str_heures) - 1);
				for($i=0 ; $i<24 ; $i++)
				{

					if($table_occupation[$i] == 0)
					{
						echo('<td height="20px" bgcolor="green"></td>');
					}
					else
					{
						echo('<td height="20px" bgcolor="red"></td>');
					}
				}
			}
		}
		?>
		</tr></table>
	</tr>
</table>
<table align="center" border="0" cellpadding="5" cellspacing="0"  class="tab_numero">
</table>
<?php
	echo('<textarea style="display: block; margin-left: auto; margin-right: 
		auto;" name="message" rows="6" class="form-control" id="message" placeholder="Votre message" required="">');
	if($str_heures != "")
	{
		$tabLocations = explode(";",$str_heures);
		for($i=0 ; $i<count($tabLocations) ; $i++)
		{
			$infosLocation = explode(",",$tabLocations[$i]);
			echo($infosLocation[0].' : '.$infosLocation[1].' - '.$infosLocation[2]."\n");
		}
	}
	echo('</textarea>');
?>

</div>
</body>
</html>
