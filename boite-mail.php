<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Plateforme de location</title>
<!--

Template 2089 Meteor

http://www.tooplate.com/view/2089-meteor

-->
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/fontAwesome.css">
        <link rel="stylesheet" href="css/hero-slider.css">
        <link rel="stylesheet" href="css/tooplate-style.css">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
		<style>
			
		</style>
    </head>
	<?php
	session_start ();
include('confi.php');

	
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
                        <p>Un large choix d'objets � louer, de la cafeti�re aux engins de chantier <?php
				echo $_GET['login'];  
				?></p>
                  </div>                   
              </div> 
				
		 
				<!-- .cd-full-width -->
		
            </li>
	
        </ul> 
		
        <!-- .cd-hero-slider -->

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
	
  
						   


    <footer>
        <div class="container">
		
		<table width="200" border="1">
  <tr>
    <td>&nbsp; 	<div class="primary-button"><form action="boite mail.php"> <input type="button" value="boite de reception" > </form> </div>    <br><div class="primary-button"></div> </td>
	
	
	
    <td>&nbsp;
	<?php
	$logo=$_GET['login'];
	$query="SELECT * FROM message,locataire WHERE message.recepteur=locataire.id_locataire and locataire.login='$logo'";
	$results = mysqli_query($link,$query) or die ("echec de l'exécution de la requête<br>."  . mysql_error());
	$compter = mysqli_num_rows($results);
	
		
	?>
	<table width="200" border="1" background="img/blog-bg.png" >
      <tr>
        <td>émetteur</td>
        <td>object</td>
        <td>message</td>
      </tr>
	  <?php
	
	$results = mysqli_query($link,$query) or die ("echec de l'exécution de la requête<br>."  . mysql_error());
	$compter = mysqli_num_rows($results);
	  while($data=mysqli_fetch_array($results)){
	  while($donnee=mysqli_fetch_array($results)){
	  ?>
      <tr>
         <td ><?php echo ($donnee['emetteur']); ?> 
        <td ><?php echo ($donnee['object']); ?> </td>
        <td><?php echo ($donnee['text']); ?> </td>
      </tr>
    </table>	</td>
  </tr>
</table>
<?php
}}
?>
		
		
 <div id="contact" class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h4>Contact Us</h4>
                        <div class="line-dec"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="map"></div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                      <form id="contact" action="" method="get">
                        <div class="col-md-6">
                          <fieldset>
                            <input name="name" type="text" class="form-control" id="name" placeholder="A" required="">
                          </fieldset>
                        </div>
                        <div class="col-md-6">
                          <fieldset>
                            <input name="email" type="email" class="form-control" id="email" placeholder="object" required="">
                          </fieldset>
                        </div>
                        <div class="col-md-12">
                          <fieldset>
                            <textarea name="message" rows="6" class="form-control" id="message" placeholder=" message" required=""></textarea>
                          </fieldset>
                        </div>
                        <div class="col-md-12">
                          <fieldset>
                           <div class="col-md-12">
                          <fieldset>
                            <input name="envoyer" rows="6" class="form-control" type="submit" name="envoyer" value="envoyer"> 
                          </fieldset>
                        </div>
                          </fieldset>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
	if(isset($_GET['envoyer'])){
	
	}
	
	?>						  
	
				
						
						

          <div class="row"></div>
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