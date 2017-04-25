<?php include '../../functions.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'metadata_inc.php'; ?>
</head>
<body>
  <!-- navigation bar -->
  <?php include 'navbar.php'; ?>

  <!-- call article and images from database -->
  <section id="detail">
    <div class="row">
      <?php include 'item_detail.php'; ?>
    </div>
  </section>

  <!-- footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
<!---->
