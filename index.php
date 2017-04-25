<!-- functions.php: establish DB connection -->
<?php include '../../functions.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'metadata_inc.php'; ?>
  </head>

  <body>
  <!-- the navigation bar was inspired from https://shapebootstrap.net/item/1524963-evento-free-music-event-template -->
    <?php include 'navbar_main.php'; ?>

    <!-- carousel -->
    <?php include 'carousel.php'; ?>
    <div id="carrouselBorder">
    	 <img class="iconImg" src="img/carrouselLine3.png" />
    </div>

    <!-- get random articles from the database -->
    <section id="learn">
      <div class="container icons">
        <div class="row">
          <?php include 'learn_item.php'; ?>
        </div>
      </div>
    </section>

    <!-- include footer -->
    <?php include 'footer.php'; ?>

  </body>
</html>
