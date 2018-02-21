<?php
	include('confi.php');
	$recherche = $_GET["recherche"];
	if (strlen($recherche)<2){
		echo "<div style=\" font-size:15px; text-align:center; font-family:palatino Linotype;\">Vous devez saisir au moins 2 caracteres!</div>";
	}else{
		$l="SELECT DISTINCT objet.nom, objet.prix, objet.prelevement, objet.nbpassage, objet.caution, objet.adresseimage,
			objet.publicvise, objet.disponible, objet.Ville, objet.specialite, objet.id_objj,
			objet.adressePostale
			FROM objet
			WHERE objet.nom LIKE '".$recherche."'";
			
			
		if($e=mysqli_query($link,$l))
		{
		$compter = mysqli_num_rows($e);
		if ($compter<=0){
			echo "<div style=\" font-size:15px; text-align:center; font-family:palatino Linotype; color:white;\">Cet objet n'existe pas!</div>";
		}
		else{
?>
					
		<div class="container">	
			<div class="row"> 
				<div> 		
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr bgcolor="white" style="font-weight: bold">
						  <td><div align="center" class="Style8">Image</div></th>
						  <td><div align="center" class="Style8">Nom </div></td>
						  <td><div align="center" class="Style8">Prix </div></td>
						  <td><div align="center" class="Style8">Passages</div></td>
						  <td><div align="center" class="Style8">caution</div></td>
						  <td><div align="center" class="Style8">Public visé</div></td>
						  <td><div align="center" class="Style8">Ville</div></td>
						  <td><div align="center" class="Style8">Spécialité</div></td>
						  <td><div align="center" class="Style8">Distance</div></td>
						  <td><div align="center" class="Style8">_</div></td>
						  <td><div align="center" class="Style8">_</div></td>
					</tr>
				</thead>
				<tbody>
		<?php
		 $resultat_recherche=mysqli_query($link, $l);
		 $i = 0;
		 $tabAdresses = array();
		while($donnee=mysqli_fetch_array($e)){
			if(isset($donnee['disponible']) && $donnee['disponible']==1){
		?>
			<tr bgcolor="white" style="vertical-align:middle;">
				<?php echo '<td style="background-image:url(img/'.$donnee['adresseimage'].');"></td>';?>
				<td><div align="center" class="item"><?php echo ($donnee['nom']); ?></div></td>
				<td><div align="center" class="item"<?php echo (' id="prix'.$i.'">'.$donnee['prix'].'/'.$donnee['prelevement']); ?></div></td>
				<td><div align="center" class="item"><?php echo ($donnee['nbpassage']); ?></div></td>
				<td><div align="center" class="item"><?php echo ($donnee['caution']); ?></div></td>
				<td><div align="center" class="item"><?php echo ($donnee['publicvise']); ?></div></td>
				<td><div align="center" class="item" <?php echo('id="ville-'.$i.'"');?>><?php echo($donnee['Ville']); ?></div></td>
				<td><div align="center" class="item"><?php echo($donnee['specialite']); ?></div></td>
				<td><div align="center" class="item" <?php echo('id="dist-'.$i.'"');?>></div></td>
				<?php echo '<td><button id="calendar'.$i.'" style="border:0px; width:70px; height:70px; background-image:url(img/calendar-icon.png);"/></button></td>';?>
				<td align="center"><button type="submit" <?php echo('id="valide'.$i.'"');?> style="background-color:green; color:white;"class="btn">Valider</button></td>
			</tr>
			<p style="visibility:hidden;"<?php echo(' id="objid-'.$i.'"');?>><?php echo($donnee['id_objj']);?></p>

       <?php
			$i++;
			}
		}
		?>
			</tbody>
		</table>
		</div>
		</div>
	</div>
<?php
				}
			}
		}
?>