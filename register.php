<?php include '../../functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'metadata_inc.php'; ?>
  <script type="text/javascript" src="js/register_wizard.js"></script>
</head>

<body id='wizard_body'>
  <?php include 'navbar.php'; ?>
  <!-- form -->
  <form action="post_register.php" method="post" enctype="multipart/form-data">
    <?php include 'register_wizard.php'; ?>
  </form>
  <!-- /form -->

  <?php include 'footer.php'; ?>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
  <script>
    $.validate();
    $.validate({
       modules : 'security'
     });
  </script>
</body>
</html>
