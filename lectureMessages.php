<?php
	include('confi.php');
	$idMessage=$_POST['idMessage'];
	$query="SELECT message.text FROM message WHERE message.id_message='$idMessage'";
	$mettreLu = "UPDATE `message` SET `lu` = '1' WHERE `message`.`id_message`='$idMessage'"
?>
<div class="container">	
		<div class="row"> 
			<div class="col-md-12">
			  <fieldset>
					<textarea name="message" rows="6" class="form-control" id="message">
					<?php
						if($results = mysqli_query($link,$query))
						{
							if($donnee=mysqli_fetch_array($results))
							{
								echo($donnee['text']);
							}
						}
						if(!mysqli_query($link,$mettreLu))
						{
							echo("Erreur mise à lu");
						}
					?>
					</textarea>
			  </fieldset>
			</div>		
		</div>			
</div>			