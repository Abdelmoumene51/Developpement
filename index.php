<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Plateforme de location</title>
<!--

Template 2089 Meteor

http://www.tooplate.com/view/2089-meteor

-->
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/fontAwesome.css">
        <link rel="stylesheet" href="css/hero-slider.css">
        <link rel="stylesheet" href="css/tooplate-style.css">
	
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="bootstrap-3.2.0-dist/js/bootstrap.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
		<script src="geolocalisation.js"></script>
		
		<script>
		var nomCookie = "authentification";
		var tabBoutonsRepondre = [];
		var tabBoutonsValider = [];
		String.prototype.replaceAll = function(str1, str2, ignore) 
		{
			return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
		} 
		async function writeDistance(details, nbLignes)
		{
			var i=0;
			var result = await computeDistanceWithAdress(details[0],details[1]);
			while(i<nbLignes)
			{
				if(document.getElementById('dist-'+i).innerHTML == "" && document.getElementById('ville-'+i).innerHTML == details[1])
				{
					$("#dist-"+i).append(result.toFixed(1)+" km");
				}
				i++;
			}
		}
		function encodeMessage (str) {  
			return encodeURIComponent(str).replace(/[']/g,"\'");  
		}
		function getCookie(sName) {
			var oRegex = new RegExp("(?:; )?" + sName + "=([^;]*);?");
			if (oRegex.test(document.cookie)) {
					return decodeURIComponent(RegExp["$1"]);
			} else {
					return null;
			}
		}
		function estDejaCookifie(idObj)
		{
			var cookieIdsCommandes;
			var i=0;
			var result = false;
			if((cookieIdsCommandes = getCookie("idsCommandes")) != null)
			{
				var cookieSplit = cookieIdsCommandes.split(',');
				console.log(idObj);
				while(result == false && i<cookieSplit.length)
				{
					if(cookieSplit[i] == idObj)
					{
						result = true;
					}
					i++;
				}
			}
			return result;
		}
		var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;
			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		};
			$(document).ready(function(){
				$("a").click(function(){
					if(this.id == "panierButton")
					{
						$("#what-we-do").empty();
						$.ajax({
						   url : 'panier.php',
						   type : 'GET',
						   dataType : 'html',
						   success : function(code_html, statut){
							   $("#what-we-do").append(code_html);
							   var envoyerDemandeButton;
							   var i=0;
							   while(envoyerDemandeButton = document.getElementById('envoiDemande'+i))
							   {
								   envoyerDemandeButton.addEventListener("click", function(){
									   var idButton = this.id;
										$.ajax({
										   url : 'formulaireDemande.php',
										   type : 'GET',
										   dataType : 'html',
										   success : function(code_html, statut){
											   $("#periodeLocation").empty();
											   $("#periodeLocation").append(code_html);
											   console.log(idButton.substr(12));
											   document.getElementById("debutloc").value = (document.getElementById('dateLocation'+idButton.substr(12)).innerHTML).split("--")[1];
												document.getElementById('notifier').addEventListener("click", function(){
													notifier(document.getElementById('loginLoc'+idButton.substr(12)).innerHTML,document.getElementById('idObjPanier'+idButton.substr(12)).innerHTML,$("#debutloc").val(),$("#finloc").val());
												});
										   },
										   error : function(resultat, statut, erreur){
												console.log(resultat);
										   },
										   complete : function(resultat, statut){
												console.log(resultat);
										   }
										});
								   });
								   i++;
							   }
						   },
						   error : function(resultat, statut, erreur){
								console.log(resultat);
						   },
						   complete : function(resultat, statut){
								console.log(resultat);
						   }
						});
							
					}
				});
				$("button").click(function(){
					if(this.id == "rechercheButton")
					{
						/* Génération du tableau d'objets */
						$.ajax({
						   url : 'rechercheObjets.php',
						   type : 'GET',
						   data : 'recherche=' + $("#recherche").val(),
						   dataType : 'html',
						   success : function(code_html, statut){
						       $("#tabObjets").empty();
							   $("#tabObjets").append(code_html);
							   /* Calcul des distances */
								$.ajax({
								   url : 'getAdresses.php',
								   type : 'GET',
								   data : 'recherche=' + $("#recherche").val(),
								   dataType : 'html',
								   success : function(result_text, statut){
									   console.log(result_text);
									   var result = result_text.split(";")
									   for(i=1 ; i<(parseInt(result[0])+1) ; i++)
									   {
										   var details = result[i].split("+");
										   var distField;
										   var calen;
										   var boutonValide;
										   if(distField = document.getElementById('dist-'+(i-1)))
										   {
											   writeDistance(details,parseInt(result[0]));
										   }
										   if(calen = document.getElementById("calendar"+(i-1)))
										   {
											   calen.addEventListener("click", function(){
													calendrier(parseInt(this.id.substring(8)));
											   });
										   }
										   if(boutonValide = document.getElementById("valide"+(i-1)))
										   {
												tabBoutonsValider[i-1] = function(){
												   enregistrerCommande(document.getElementById("objid-"+this.id.substring(6)).innerHTML,this.id);
											    };
												if(!estDejaCookifie(document.getElementById("objid-"+(i-1)).innerHTML))
												{
													console.log(estDejaCookifie(("objid-"+(i-1)).innerHTML)+" ; "+document.cookie+" ; "+document.getElementById("objid-"+(i-1)).innerHTML+" ; "+i);
													boutonValide.addEventListener("click", tabBoutonsValider[i-1]);
												}
										   }
									   }
								   },
								   error : function(resultat, statut, erreur){
										console.log(resultat);
								   },
								   complete : function(resultat, statut){
										console.log(resultat);
								   }
								});
						   },
						   error : function(resultat, statut, erreur){
								console.log(resultat);
						   },
						   complete : function(resultat, statut){
								console.log(resultat);
						   }
						});
						
					}
					/*
					
					
					*/
					/* Lire messages reçus */
					if(this.id == "lireButton")
					{
						var login;
						if((login = getCookie(nomCookie)) !== null)
						{
							console.log(login);
							$.ajax({
							   url : 'lireMessages.php',
							   type : 'POST',
							   data : 'login=' + login,
							   dataType : 'html',
							   success : function(code_html, statut){
								   var boutonRepondre;
								   var i=0;
								   $("#messagerie").empty();
								   $("#messagerie").append(code_html);
								   while((tabBoutonsRepondre[i] = document.getElementById("repondre"+i)) !== null)
								   {
									   tabBoutonsRepondre[i].addEventListener("click", function(){
											repondreListener(this.id);
										});
										document.getElementById('lecture'+i).addEventListener("click", function(){
											lectureMessage(this.id.substr(7));
										});
										i++;
								   }
							   },
							   error : function(resultat, statut, erreur){
									console.log(resultat);
							   },
							   complete : function(resultat, statut){
									console.log(resultat);
							   }
							});
						}
					}
					/* Ecrire message */
					if(this.id == "ecrireButton")
					{
						var login;
						if((login = getCookie(nomCookie)) !== null)
						{
							$("#messagerie").load('ecrireMessages.html',function() {
								document.getElementById('envoyer').addEventListener("click", function(){
									envoyer();		
								});
							});
						}
					}
					if(this.id == "envoyer")
					{
						envoyer();
					}
				});
			});
			function repondreListener(id)
			{
				var index = parseInt(id.substr(8));
				console.log('objet'+index);
				var objet = document.getElementById('objet'+index).innerHTML;
				var destinataire = document.getElementById('emetteur'+index).innerHTML;
				var login;
				if((login = getCookie(nomCookie)) !== null)
				{
					$("#messagerie").load('ecrireMessages.html', function() {
						document.getElementById('name').value = destinataire;
						document.getElementById('objet').value = "Re : "+objet;
						document.getElementById('envoyer').addEventListener("click", function(){
							envoyer();		
						});
					});
				}
			}
			function envoyer()
			{
				var login;
				if((login = getCookie(nomCookie)) !== null)
				{
					console.log(encodeURI('login='+login+'&recepteur='+$("#name").val()+'&objet='+$("#objet").val().replaceAll("'","\\'")+'&texte='+$("#message").val().replaceAll("'","\\'")));
					if($("#name").val() != "admin")
					{
						$.ajax({
						   url : 'envoyerMessages.php',
						   type : 'GET',
						   data : encodeURI('login='+login+'&recepteur='+$("#name").val()+'&objet='+$("#objet").val().replaceAll("'","\\'")+'&texte='+$("#message").val().replaceAll("'","\\'")),
						   dataType : 'html',
						   success : function(code_html, statut){
							   console.log(code_html);
						   },
						   error : function(resultat, statut, erreur){
								console.log(resultat);
						   },
						   complete : function(resultat, statut){
								console.log(resultat);
						   }
						});
					}
					else
					{
						console.log($("#message").val().split("?")[1]);
						$.ajax({
						   url : 'validerCommande.php',
						   type : 'GET',
						   data : $("#message").val().split("?")[1],
						   dataType : 'html',
						   success : function(code_html, statut){
							   console.log(code_html);
						   },
						   error : function(resultat, statut, erreur){
								console.log(resultat);
						   },
						   complete : function(resultat, statut){
								console.log(resultat);
						   }
						});
					}
				}
			}
			function notifier(login, idObj, dateDebutLoc, dateFinLoc)
			{
				$.ajax({
				   url : 'enregistrerCommande.php',
				   type : 'GET',
				   data : 'login='+login+'&debutloc='+dateDebutLoc+'&finloc='+dateFinLoc+'&idObj='+idObj,
				   dataType : 'html',
				   success : function(code_html, statut){
					   console.log(code_html);
				   },
				   error : function(resultat, statut, erreur){
						console.log(resultat);
				   },
				   complete : function(resultat, statut){
						console.log(resultat);
				   }
				});
				$("#messagerie").empty();
				$("#messagerie").load('ecrireMessages.html', function() {
					var lien = encodeURI("validerCommande.php?idObj="+idObj+"&login="+login+"&debutloc="+dateDebutLoc+"&finloc="+dateFinLoc);
					document.getElementById('name').value = login;
					document.getElementById('objet').value = "Récupération d'un objet";
					document.getElementById('message').value = "Bonjour,\n\n Je souhaiterais louer un objet dans la période suivante : "+dateDebutLoc+" - "+dateFinLoc+
					"\n, si vous êtes d'accord, envoyez sur le lien suivant à admin depuis la messagerie : "+lien;
					document.getElementById('envoyer').addEventListener("click", function(){
						envoyer();		
					});
				});
			}
			function calendrier(id)
			{
			   var height = 450;
			   var width = 450;
			   var left = (window.screen.width / 2) - ((width / 2) + 10);
			   var top = (window.screen.height / 2) - ((height/ 2) + 50);
			   var prix = document.getElementById('prix'+id).innerHTML;
			   if(prix.substring(prix.indexOf('/')+1) !== "h")
			   {
				   var win = window.open("calendrier_bo.php?idobjet="+document.getElementById('objid-'+id).innerHTML,"_blank",
						"status=no,height=" + height + ",width=" + width + ",resizable=yes,left="
						+ left + ",top=" + top + ",screenX=" + left + ",screenY="
						+ top + ",menubar=no,location=no");
			   }
			   else
			   {
					console.log('objid-'+id);
					var win = window.open("journalier.php?idobjet="+document.getElementById('objid-'+id).innerHTML,"_blank",
						"status=no,height=" + height + ",width=" + width + ",resizable=yes,left="
						+ left + ",top=" + top + ",screenX=" + left + ",screenY="
						+ top + ",location=no");
			   }
			}
			function lectureMessage(id)
			{
				$.ajax({
				   url : 'lectureMessages.php',
				   type : 'POST',
				   data : 'idMessage=' + document.getElementById('message'+id).innerHTML,
				   dataType : 'html',
				   success : function(code_html, statut){
					   $("#champMessage").empty();
					   $("#champMessage").append(code_html);
				   },
				   error : function(resultat, statut, erreur){
						console.log(resultat);
				   },
				   complete : function(resultat, statut){
						console.log(resultat);
				   }
				});
			}
			function enregistrerCommande(id,valideButton)
			{
				document.getElementById('accuseValide').style.visibility='visible';
				setTimeout("document.getElementById('accuseValide').style.visibility='hidden';",2000);
				if(getCookie("idsCommandes") != null)
				{
					document.cookie = "idsCommandes="+getCookie("idsCommandes") +","+id;
				}
				else
				{
					document.cookie = "idsCommandes="+id;
				}
				document.getElementById(valideButton).removeEventListener("click",tabBoutonsValider[parseInt(valideButton.substr(6))]);
				console.log(document.cookie);
			}
		</script>
		<style>
			body{
				font-size: 16px;
				font-family: Arial;
			}
			img{
				padding: 10px;
			}
			.item{
				height: 50px;
				float: none;
			}
		</style>
    </head>
<?php

include('confi.php');
$recherche;
if(isset($_GET['recherche']))
{
	$recherche = $_GET['recherche'];
}
$statutMessagerie = 'ecriture';
?>
<body>
    <div class="header">
        <div class="container">
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand scroll-top">
                        <div class="logo"></div>
                    </a>
                </div>
                <!--/.navbar-header-->
                <div id="main-nav" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
						<?php
							if(!isset($_COOKIE["authentification"]))
							{
								echo '<li><a href="connexion.php">Connexion</a></li>';
								echo '<li><a href="#" class="scroll-link" data-id="portfolio">Inscription</a></li>';
							}
							else
							{
								echo '<li><a href="#" class="scroll-top">Louer</a></li>';
								echo '<li><a href="#" id="panierButton" class="scroll-link" data-id="what-we-do">Panier</a></li>';
								$countNonLus="SELECT message.recepteur, message.lu FROM message WHERE message.lu = 0 AND message.recepteur = '".$_COOKIE["authentification"]."'";
								if($results = mysqli_query($link,$countNonLus))
								{
									$compter = mysqli_num_rows($results);
									if($compter>0)
									{
										echo '<li><a href="#" class="scroll-link" data-id="portfolio"><b><font color="CF0000">Messagerie('.$compter.')</font></b></a></li>';
									}
									else
									{
										echo '<li><a href="#" class="scroll-link" data-id="portfolio">Messagerie</a></li>';
									}
								}
								echo '<li><a href="deconnexion.php">Déconnexion</a></li>';
								echo '<li><a href="#" class="scroll-link" data-id="contact">Validation</a></li>';
							}
						?>
                    </ul>
                </div>
                <!--/.navbar-collapse-->
            </nav>
            <!--/.navbar-->
        </div>
        <!--/.container-->
    </div>
    <!--/.header-->


    <section class="cd-hero">
        <ul class="cd-hero-slider autoplay">  
        <!-- 
            <ul class="cd-hero-slider autoplay"> for slider auto play 
            <ul class="cd-hero-slider"> for disabled auto play
        -->
            <li class="selected first-slide">
                <div class="cd-full-width">
                    <div class="tm-slide-content-div slide-caption">
                        <span>Bienvenue sur notre</span>
                        <h2>Plateforme de location</h2>
                        <p>Un large choix d'objets à louer, de la cafetière aux engins de chantier</p>
                        <div class="primary-button">
                            <a href="#" class="scroll-link" data-id="about">Connexion</a>
                        </div>                           
                    </div>                   
                </div> <!-- .cd-full-width -->
            </li>

            <li class="second-slide">
                <div class="cd-full-width">
                    <div class="tm-slide-content-div slide-caption">
                        <span>Rejoignez-nous</span>
                        <h2>Pas encore inscrit ?</h2>
                        <p>Une fois inscrit vous pourrez louer des objets</p>
                        <div class="primary-button">
                            <a href="#">Inscription</a>
                        </div>                        
                    </div>                     
                </div> <!-- .cd-full-width -->
            </li>

            <li class="third-slide">
                <div class="cd-full-width">
                    <div class="tm-slide-content-div slide-caption">
                        <span>Site adapté pour les mobiles</span>
                        <h2>Design Responsive</h2>
                        <p>Accédez au site depuis votre mobile</p>
                        <div class="primary-button">
                            <a href="#">Home</a>
                        </div>                           
                    </div>                         
                </div> <!-- .cd-full-width -->
            </li>
        </ul> <!-- .cd-hero-slider -->

        <div class="cd-slider-nav">
            <nav>
                <span class="cd-marker item-1"></span>
                
                <ul>
                    <li class="selected"><a href="#0"></a></li>
                    <li><a href="#0"></a></li>
                    <li><a href="#0"></a></li>                        
                </ul>
            </nav> 
        </div> <!-- .cd-slider-nav -->
    </section> <!-- .cd-hero -->
    <div id="blog" class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h4>Rechercher un objet</h4>
                        <div class="line-dec"></div>
                    </div>
                </div>
            </div>
			<!----------------------------------------------------------------------------------------------------------------------------------------->
            <div align="center">
				<table>
				  <tr>
					<td>
					<label align="center">
					  <input type="text" id="recherche" />
					</label>
					</td>
					<td><label>
					  <button id="rechercheButton">Rechercher</button>
					</label></td>
				  </tr>
				</table>
				<div id="accuseValide" align="center" style="visibility:hidden;" color="green"><b><font color="00FF00">Commande enregistrée !</font></b></div>
			</div>
			<div id="tabObjets"></div>
		</tr>
	  </table>
	</div>
</div>
    <div id="contact" class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h4>Messagerie instantanée</h4>
                        <div class="line-dec"></div>
                    </div>
					<div align="center"><fieldset align="center">
						<button type="submit" id="lireButton" class="btn"> Lire messages </button>
						<button type="submit" id="ecrireButton" class="btn">Ecrire message</button>
					</fieldset></div>
					<br>
                </div>
            </div>
			<div class="row" id="messagerie">
			<?php
				if($statutMessagerie == 'ecriture')
				{
					include('ecrireMessages.html');
				}
				else if($statutMessagerie == 'lecture')
				{
					include('lireMessages.php');
				}
				else
				{
					echo '<p>Vous n\'êtes pas connecté !</p>';
				}
			?>
			</div>
			<div class="row" id="champMessage">
			</div>
        </div>
    </div>
	<span id="what-we-do"></span>
	
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="copyright-text">
                        <p>Copyright &copy; 2017 Wallace Entreprise
                        
                        - Réalisé par : <a href="http://www.tooplate.com" target="_parent">EDGAR</a></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="social-icons">
                        <ul>
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-rss"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        // navigation click actions 
        $('.scroll-link').on('click', function(event){
            event.preventDefault();
            var sectionID = $(this).attr("data-id");
            scrollToID('#' + sectionID, 750);
        });
        // scroll to top action
        $('.scroll-top').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop:0}, 'slow');         
        });
        // mobile nav toggle
        $('#nav-toggle').on('click', function (event) {
            event.preventDefault();
            $('#main-nav').toggleClass("open");
        });
    });
    // scroll function
    function scrollToID(id, speed){
        var offSet = 50;
        var targetOffset = $(id).offset().top - offSet;
        var mainNav = $('#main-nav');
        $('html,body').animate({scrollTop:targetOffset}, speed);
        if (mainNav.hasClass("open")) {
            mainNav.css("height", "1px").removeClass("in").addClass("collapse");
            mainNav.removeClass("open");
        }
    }
    if (typeof console === "undefined") {
        console = {
            log: function() { }
        };
    }
    </script>
</body>
</html>