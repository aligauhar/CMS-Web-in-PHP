 <!-- handling the mobile as well as the web view with the bootstrape -->
 <!-- this code contains all the info about the navigation bar of the website -->
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
 	<div class="container">
 		<div class="navbar-header">
			<!-- this is the burger point for mobile view -->
			<!-- here the toggle button is targetting the list below with the id bs-example-navbar-collapse-1 -->
 			<button type="button" class="navbar-toggle" data-toggle="collapse"
 				data-target="#bs-example-navbar-collapse-1">
				<!-- making animation of the button -->
 				<span class="icon-bar"></span>
 				<span class="icon-bar"></span>
 				<span class="icon-bar"></span>
 			</button>
			<!-- CMS leads to the main page of the website -->
 			<a class="navbar-brand" href="index.php">CMS</a>
 		</div>
		<!-- list to thhe other pages -->
 		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
 			<ul class="nav navbar-nav">
 				<li><a href="about.php">About Us</a></li>
 				<li><a href="publicposts.php">Trending Content</a></li>
 				<li><a href="register.php">Register</a></li>
 			</ul>
 		</div>
 	</div>
 </nav>