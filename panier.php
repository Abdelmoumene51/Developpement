<?php
	include('confi.php');	
?>
	<div id="what-we-do">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="section-heading">
							<h4>Panier</h4>
							<div class="line-dec"></div>
							<br>
								<div class="container">	
									<div class="row"> 
										<div> 		
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr bgcolor="white" style="font-weight: bold; color:black">
												  <td><div align="center" class="Style8">Image</div></th>
												  <td><div align="center" class="Style8">Nom</div></td>
												  <td><div align="center" class="Style8">Login</div></td>
												  <td><div align="center" class="Style8">Location</div></td>
												  <td><div align="center" class="Style8">Prix total</div></td>
												  <td><div align="center" class="Style8">Récupération chez le locataire</div></td>
											</tr>
										</thead>
										<tbody>
								<?php
								 // Sélection des ids Commandes
								 if(isset($_COOKIE["idsCommandes"]))
								 {	 
									$idsCommandes = explode(",",$_COOKIE["idsCommandes"]);
									$j=0;
									 for($i=0 ; $i<count($idsCommandes) ; $i++)
									 {
										 $l="SELECT objet.nom, location.datefin,location.datedebut, objet.adresseimage, objet.caution, objet.prix, objet.prelevement,
										locataire.login, objet.id_objj
										FROM objet, location, locataire 
										WHERE location.id_objj = ".$idsCommandes[$i]."
										AND objet.id_objj = location.id_objj
										AND locataire.id_locataire = location.id_locataire";
										if($e=mysqli_query($link,$l))
										{
											while($donnee=mysqli_fetch_array($e))
											{
									?>
												<tr bgcolor="white" style="vertical-align:middle; color:black;">
													<?php echo '<td style="background-image:url(img/'.$donnee['adresseimage'].');"></td>';?>
													<td><div align="center" class="item"><?php echo ($donnee['nom']); ?></div></td>
													<td><div align="center" <?php echo('id="loginLoc'.$j.'"'); ?> class="item"><?php echo ($donnee['login']); ?></div></td>
													<td><div align="center" <?php echo('id="dateLocation'.$j.'"'); ?> class="item"><?php echo ($donnee['datedebut']." -- ".$donnee['datefin']); ?></div></td>
													<td><div align="center" class="item"><?php echo ($donnee['caution'].'€ + '.$donnee['prix'].'€/'.$donnee['prelevement']); ?></div></td>
													<td><div align="center" class="item"><button type="submit" <?php echo('id="envoiDemande'.$j.'"');?> style="background-color:green; color:white;"class="btn">Envoyer une demande</button></td>
												</tr>
												<?php echo('<span style="visibility:hidden;" id="idObjPanier'.$j.'">'.$donnee['id_objj'].'</span>'); ?>
									
									<?php		
											$j++;
											}
										}
									 }
								 }
								?>
							</tbody>
						</table>
						<span id="periodeLocation"></span>
						</div>
						</div>
					</div>
					</div>
			</div>
		</div>
		<div class="row" id="panier">
		</div>
	</div>
</div>