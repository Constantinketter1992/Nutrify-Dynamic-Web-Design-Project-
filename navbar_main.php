<!-- part of the navigation (the part that is static like the home tab) is set up dynamically from the database: refer to "navbar_inc_id.php"  -->
<!-- the sign-in form, register, and myportal tabs are set up in the source code below   -->
<!-- when you enter the website the sign in form and register button is shown  -->
<!-- once you sign in or register, the sign in form and register button disappear and the MyPortal tab and logout button appear -->
<!-- bootstraps navbar template was used -->
<!--This navbar uses this template's design https://shapebootstrap.net/item/1524963-evento-free-music-event-template-->

<header id="header" role="banner">
	<div class="main-nav">
		<div class="container">
      <div class="row">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- logo -->
          <a class="navbar-brand" href="index.php">
            <img class="img-responsive" src="img/cc_logo_big.png" alt="logo">
          </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php include 'navbar_inc_id.php'; ?>
  				  <?php
            //if user is logged in Myportal tab and logout button
  				  if(isset($_SESSION['user_name'])) {?>
  					  <li><a href=<? echo "MyPortal.php?user_id=" .$_SESSION['userid']?>>MyPortal</a></li>
  						<li><a href="logout.php"><? echo "Logout: ".$_SESSION['user_name'].""; ?></a></li>
            <!-- else show sign up form and register button -->
  				  <? } else { ?>
              <!-- sign in form -->
  						<form class="navbar-form navbar-right" action="login.php" method="POST">
  						  <input type="text" name="email" placeholder="Email" class="form-control">
  						  <input type="password" name="password" placeholder="Password" class="form-control">
  							<button type="submit" name="submit" class="btn btn-success">Sign in</button>
  						</form>
  						 <!-- register button -->
  						<li>
    						<button class="btn btn-success" id="reg" onclick="window.location='register.php';">Register</button>
  						</li>
  				  <? } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>
