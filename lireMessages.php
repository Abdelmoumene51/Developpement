<?php
	include('confi.php');
	$logo=$_POST['login'];
	$query="SELECT * FROM message WHERE message.recepteur='$logo'";
	if($results = mysqli_query($link,$query))
	{
		$compter = mysqli_num_rows($results);
?>
		<div class="container">	
			<div class="row"> 
				<div> 		
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr bgcolor="white" style="font-weight: bold">
						  <td><div align="center" class="Style8">Emetteur</div></th>
						  <td><div align="center" class="Style8">Objet</div></th>
						  <td><div align="center" class="Style8">Message</div></td>
						  <td width="70px" style="max-width:70px;"><div align="center" class="Style8">Lire</div></td>
						  <td width="70px"><div align="center" class="Style8">-</div></td>
					</tr>
				</thead>
				<tbody>
	<?php
		$i=0;
		while($donnee=mysqli_fetch_array($results)){
			echo('<p hidden id="message'.$i.'">'.$donnee['id_message'].'</p>');
			if($donnee['lu'] == 0)
			{
				echo('<tr height="70px" class="info">');
			}
			else
			{
				echo('<tr height="70px" bgcolor="white">');
			}
				echo ('<td><div align="center" class="item" id="emetteur'.$i.'">'.$donnee['emetteur'].'</div></td>');
				if(strlen($donnee['object']) > 20)
				{
					echo '<td><div align="center" class="item" id="objet'.$i.'">'.substr($donnee['object'],0,20).'...</div></td>';
				}
				else
				{
					echo '<td><div align="center" class="item" id="objet'.$i.'">'.$donnee['object'].'</div></td>';
				}
				if(strlen($donnee['text']) > 20)
				{
					echo('<td><div align="center" class="item">'.substr($donnee['text'],0,20).'...</div></td>');
				}
				else
				{
					echo('<td><div align="center" class="item">'.$donnee['text'].'</div></td>');
				}
				
				echo '<td style="max-width:70px; background :url(img/zoomplus.png);  background-repeat: no-repeat;"><button type="submit" style="width:100%; border:none; display:inline-block; background:transparent;" id="lecture'.$i.'"></td>';
				echo('<td><button type="submit" id="repondre'.$i.'" class="btn">Repondre</button></td></tr>');

			$i++;
		}
	}
?>
		</tbody>
	</table>
	</div>
	</div>
</div>