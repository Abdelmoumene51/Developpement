<html>
<head>
<title>Planning</title>
<link href="calendar.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include("fonctions.php");
// recuperatio du jous, mois, et année actuel
$jour_actuel = date("j", time());
$mois_actuel = date("m", time());
$an_actuel = date("Y", time());
$jour = $jour_actuel;


// si la variable mois n'existe pas, mois et année correspondent au mois et à l'année courante
if(!isset($_GET["mois"]))
	{
	$mois = $mois_actuel;
	$an = $an_actuel;
	}else{
		$mois=$_GET['mois'];
		$an=$_GET['an'];
	}

//mois suivant
$mois_suivant = $mois + 1;
$an_suivant = $an;
if ($mois_suivant == 13)
{
	$mois_suivant = 1;
	$an_suivant = $an + 1;
}

//mois précédent
$mois_prec = $mois - 1;
$an_prec = $an;
if ($mois_prec == 0)
{
	$mois_prec = 12;
	$an_prec = $an - 1;
}

//affichage du mois et de l'année en french
$mois_de_annee = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre");
$mois_en_clair = $mois_de_annee[$mois - 1];
// creation d'un tableau à 31 entrée (1 pour chaues jours) et on dit qu'aucuns jours n'est resevé
for($j = 1; $j < 32; $j++){
$tab_jours[$j] = (bool)false;
}
// connexion à la bdd
include("config.inc.php");
$connexion = mysqli_connect("localhost", "root", "");
mysqli_select_db($connexion, "edgar");
$connexion = mysqli_connect("localhost", "root", "");
mysqli_select_db($connexion, "edgar");
$sql = "SELECT location.datedebut, location.datefin, locataire.login, objet.prelevement 
FROM location,locataire,objet 
WHERE location.id_objj = '".$_GET['idobjet']."'
AND locataire.id_locataire = location.id_locataire 
AND objet.id_objj = location.id_objj";

$requete = mysqli_query($connexion,"SELECT * FROM calendrier WHERE YEAR(jour) = $an AND MONTH(jour) = $mois");
while ($ligne = mysqli_fetch_array($requete)){
	// recupartion du jour ou il y a la reservation
	$jours = $ligne["jour"];
	// transforme aaaa/mm/jj en jj
	$jour_reserve = (int)substr($jours, 8, 2);
	// insertion des jours reservé dans le tableau
	$tab_jours[$jour_reserve] = (bool)true;	
}

?>
<br />

<table align="center" width="420" border="0" cellpadding="5" cellspacing="0"  class="tab_cal">
	<tr>
		<td height="51" colspan="7">
			<table width="346" border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td width="282" class="date"><div><?php echo $mois_en_clair," ", $an; ?></div></td>
					<td width="38">
						<a href="calendrier_bo.php?mois=<?php echo $mois_prec.'&idobjet='.$_GET['idobjet']; ?>&an=<?php echo $an_prec; ?>">
					  <div align="right"><img border="0" src="img/prec.gif" /></div></a>
				  </td>
					<td width="26">
						<a href="calendrier_bo.php?mois=<?php echo $mois_suivant.'&idobjet='.$_GET['idobjet']; ?>&an=<?php echo $an_suivant; ?>">
					  <div><img border="0" src="img/suiv.gif" /></div>
					  </a>					
				  </td>
				</tr>
		  </table>
	  </td>
	</tr>
	<tr align="center" class="jours">
		<td width="60">D</td>
		<td width="60">L</td>
		<td width="60">M</td>
		<td width="60">M</td>
		<td width="60">J</td>
		<td width="60">V</td>
		<td width="60">S</td>
	</tr>
</table>
<table align="center" width="420" border="0" cellpadding="5" cellspacing="0"  class="tab_numero">
	<tr align="center">
<?php

	$resultat;
	$passed = false;
	// Lorsqu'il y a une location sur le jour sélectionné, contient l'heure de début et de fin
	$heureDebutLocation = 0;
	$heureFinLocation = 0;
	//login,debut,fin;login,debut,fin
	$str_heures = "";

	if($resultat=mysqli_query($connexion,$sql))
	{
		//Détection du 1er et dernier jour du moiS
		$nombre_date = mktime(0,0,0, $mois, 1, $an);
		$premier_jour = date('w', $nombre_date);
		$dernier_jour = 28;
		while (checkdate($mois, $dernier_jour + 1, $an))
			{ $dernier_jour++;}
		$table_occupation = array();
		for($i=0 ; $i<$dernier_jour ; $i++)
		{
			$table_occupation[$i] = 0;
		}
		while($donnee=mysqli_fetch_array($resultat))
		{
			if($donnee['prelevement'] != "h")
			{
				$dateSelectionnee = date('Y-m-d',strtotime($an_actuel."-".$mois_actuel."-01"));
				if(isset($_GET['mois']) && isset($_GET['an']))
				{
					$dateSelectionnee = date('Y-m-d',strtotime($_GET['an']."-".$_GET['mois']."-01"));
				}
				$dateDebut = date('Y-m-d',strtotime($donnee['datedebut']));
				$dateFin = date('Y-m-d',strtotime($donnee['datefin']));
				$str_heures .= ($donnee['login'].",".strval($dateDebut).",".strval($dateFin).";");
				$tempDate = date('Y-m-d',strtotime($donnee['datedebut']));
				$tempDate = intval(strtotime(date('Y-m-d',strtotime($dateSelectionnee))));
				for($i=0 ; $i<$dernier_jour ; $i++)
				{
					if($tempDate >= intval(strtotime(date('Y-m-d',strtotime($dateDebut)))) 
					&& $tempDate <= intval(strtotime(date('Y-m-d',strtotime($dateFin)))))
					{
						$table_occupation[$i] = 1;
					}
					$tempDate += 86400;
					//echo($tempDate." ; ".intval(strtotime(date('Y-m-d',strtotime($dateDebut))))."<br>");
				}
			}
		}
		$str_heures = substr($str_heures,0,strlen($str_heures) - 1);
		//Affichage de 7 jours du calendrier
		for ($i = 0; $i < 7; $i++){
			if ($i < $premier_jour){ 
				echo '<td width="60"></td>';
			}else{
				$ce_jour = ($i+1) - $premier_jour;
				// si c'est un jour reserve on applique le style reserve
				if($table_occupation[$ce_jour] == 1){
					echo 'lol';
					echo '<td width="60" class="reserve">';
					echo $ce_jour;
					echo '<br />';
					// conversion de la en aaaa-mm-jj (cf fonctions.php)
					$date = ajout_zero($ce_jour, $mois, $an);
					// on supprime le jour correspondant via la page recuperation_enlever.php
					echo '</td>';					
				// sinon on ne met pas de style
				}else{
					echo '<td width="60">';
					echo $ce_jour;
					echo '<br />';
					// cf fonctions.php
					$date = ajout_zero($ce_jour, $mois, $an);
					// on ajoute le jour correspondant via la page recuperation_ajouter.php
					echo '</td>';
				}
			}
		}
		//affichage du reste du calendrier
		$jour_suiv = ($i+1) - $premier_jour;
		for ($rangee = 0; $rangee <= 4; $rangee++){
				echo '</tr>';
				echo '<tr align="center" class="numero">';
				for ($i = 0; $i < 7; $i++){
					if($jour_suiv > $dernier_jour){ 
						echo '<td width="60">';
						echo '</td>';
					}else{
						// si c'est un jour reserve on applique le style reserve
						if($table_occupation[$jour_suiv-1]){
							echo '<td width="60" class="reserve">';
							echo $jour_suiv;
							echo '<br />';
							$date = ajout_zero($jour_suiv, $mois, $an);
							echo '</td>';					
						// sinon on ne met pas de style
						}
						else{
							echo '<td width="60">';
							echo $jour_suiv;
							echo '<br />';
							$date = ajout_zero($jour_suiv, $mois, $an);
							echo '</td>';
						}
					}
					$jour_suiv++;
				}
		}
	}
?>
</tr>
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
</body>
</html>