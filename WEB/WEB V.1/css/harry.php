<?php
session_start(); // On démarre la session AVANT toute chose

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Fooye - Meet</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet"> 
    <link href="css/main.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="img/icon.jpg">

  
			

		
</head><!--/head-->

<body>

<!--.preloader-->
<div class="preloader"><i class="fa fa-circle-o-notch fa-spin"></i></div>
<!--/.preloader-->

<header id="header"> 
    <div class="container">
        <div class="container-inner">
            <div class="logo pull-left">
                <a class="pull-left logo" href="meet.php">
                    <h1><img class="img-responsive" src="img/logo.png" alt="logo"></h1>
                </a>
            </div>
            <div class="menu pull-right">
			
		
			
			
			
			
                <a href="#" class="nav-button">
                    <i class="fa fa-align-justify"></i> Menu
                </a> 
            </div>
        </div>
    </div>
</header> <!--/#header-->

<div id="navigation">
    <div class="vertical-middle">
        <div class="vertical-middle-inner">
            <div class="main-nav" >
                <a id="hidemenu" href="#"><i class="fa fa-times-circle fa-2x"></i></a>
                <ul>                     
                    <li class="active"><a href="#" data-target="#page-slider" data-slide-to="0">Home</a></li>
					
					<?php 
					
				if(isset($_SESSION['conect'])){	
					if($_SESSION['conect']){	?>
					
                    <li><a href="profil.php" data-target="#page-slider" data-slide-to="1">Mon Profil</a></li>
                    <li><a href="deco.php" data-target="#page-slider" data-slide-to="2">Se Déconecter</a></li>
				<?php }
				
				}else{	?>
					
					<li><a href="seconecter.php" data-target="#page-slider" data-slide-to="1">Connexion</a></li>
                    <li><a href="sign.php" data-target="#page-slider" data-slide-to="2">S'inscrire</a></li>       
					
			<?php } ?>

			
                </ul>
            </div>
        </div>
    </div>
</div><!--/#navigation-->
<br><br><br><br><br><br><br><br>



 <div class="container"><!--DEBUT CARTE DE VISITE-->
    	<div class="col-lg-6 col-lg-offset-3">
    	
    		<!-- ===== vCard Navigation ===== -->
    		<div class="row w">
    			<div class="col-md-4">
    				<img class="img-responsive" src="img/avatar.jpg" alt="">
					<ul class="nav nav-tabs nav-stacked" id="myTab">
					  <li class="active"><a href="#about">About</a></li>
					  <li><a href="#profile">Profile</a></li>
					  <li><a href="#portfolio">Portfolio</a></li>
					  <li><a href="#contact">Contact</a></li>
					</ul>    			
				</div><!-- col-md-4 -->

    		<!-- ===== vCard Content ===== -->
    			<div class="col-md-8">
	    			<div class="tab-content">
	    			
	    			  <!-- ===== First Tab ===== -->
					  <div class="tab-pane active" id="about">
					  	<h3>Victoria Wallberg</h3>
					  	<h5>Web Designer</h5>
					  	<hr>
					  	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p> 
					  	<p>Has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it.</p>
					  	<p class="pull-right red"><i class="icon-heart"></i></p>
					  </div><!-- tab about -->
					  
	    			  <!-- ===== Second Tab ===== -->
					  <div class="tab-pane" id="profile">
					  	<h4><i class="icon-briefcase"></i> Job Experience</h4>
					  	<p class="sm">
					  		<grey>Black Tie Corp.</grey> | June 2013 - Actual.<br/>
					  		<grey>Other Corp.</grey> | January 2011 - May 2013.<br/>
					  	</p>
					  
						  <h4><i class="icon-file-text-alt"></i> Education</h4>
					  	<p class="sm">
					  		<grey>Web Designer</grey> | Greenville University.<br/>
					  		<grey>Business Master</grey> | Loyal Univesrity.<br/>
					  	</p>
					  	
						  <h4><i class="icon-trophy"></i> Awards</h4>
					  	<p class="sm">
					  		<grey>Best Web Design</grey> | Black Tie Site.<br/>
					  		<grey>Designer of the Year</grey> | 2012.<br/>
					  	</p>
					  </div><!-- Tab Profile -->
					  
	    			  <!-- ===== Third Tab ===== -->
					  <div class="tab-pane" id="portfolio">
						  <div class="row">
							  <div class="col-xs-6 centered">
							  	<img class="img-responsive" src="img/p01.png" alt="">
							  	<a href="#"><h6><i class="icon-link"></i> Project Name</h6></a>
							  </div><!-- col-xs-6 -->
							  <div class="col-xs-6 centered">
							  	<img class="img-responsive" src="img/p02.png" alt="">
							  	<a href="#"><h6><i class="icon-link"></i> Project Name</h6></a>
							  </div><!-- col-xs-6 -->
						  </div><!-- row -->
						  
						  <div class="row">
						  	<br>	
							  <div class="col-xs-6 centered">
							  	<img class="img-responsive" src="img/p03.png" alt="">
							  	<a href="#"><h6><i class="icon-link"></i> Project Name</h6></a>
							  </div><!-- col-xs-6 -->
							  <div class="col-xs-6 centered">
							  	<img class="img-responsive" src="img/p04.png" alt="">
							  	<a href="#"><h6><i class="icon-link"></i> Project Name</h6></a>
							  </div><!-- col-xs-6 -->
						  </div><!-- row -->
					  </div><!-- /Tab Portfolio -->
					  
	    			  <!-- ===== Fourth Tab ===== -->
					  <div class="tab-pane" id="contact">
						  <h4>Contact Information</h4>
						  <hr>
						  <div class="row">
							  <div class="col-xs-6">
								  <p class="sm">
								  	<i class="icon-globe"></i> - BlackTie.co <br/>
									<i class="icon-envelope"></i> - victoria@blacktie.co  
								  </p>
							  </div><!-- col-xs-6 -->
							  
							  <div class="col-xs-6">
								  <p class="sm">
								  	<i class="icon-phone"></i> - +44 2009-4839 <br/>
									<i class="icon-apple"></i> - 902 3940-4439  
								  </p>
							  </div><!-- col-xs-6 -->
						  </div><!-- row -->
						  
						  <h4>Social Links</h4>
						  <hr>
						  <div class="row">
							  <div class="col-xs-6">
								  <p class="sm">
								  	<i class="icon-facebook"></i> - Vicky.Wallberg <br/>
									<i class="icon-tumblr"></i> - Love-Vicky-Site  
								  </p>
							  </div><!-- col-xs-6 -->
							  
							  <div class="col-xs-6">
								  <p class="sm">
								  	<i class="icon-dribbble"></i> - Vicoooria <br/>
									<i class="icon-twitter"></i> - @BlackTie_co  
								  </p>
							  </div><!-- col-xs-6 -->
						  </div><!-- row -->
					  </div><!-- Tab Contact -->
					  
					</div><!-- Tab Content -->
    			</div><!-- col-md-8 -->
    		</div><!-- row w -->
    	</div><!-- col-lg-6 -->
    </div><!-- /.container --> <!--FIN DE CARTE DE VISITE -->


 <br><br><br><br><br>



<footer id="footer" class="text-center">
    <center><p>Copyright © 2023 Fooye Indus. All rights reserved.</p></center>
</footer>
   <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script>
	$('#myTab a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})	
	</script>   
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>  
<script type="text/javascript" src="js/main.js"></script>

</body>
</html>