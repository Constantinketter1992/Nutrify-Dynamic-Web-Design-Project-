<?php include '../../functions.php'; ?>

<?php

  if(isset($_POST['submit'])){
  /* getConnection() function is in the functions.php that is 'included' at the top */
    $mysqli = getConnection();

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    /* create a prepared statement */
    $stmt =  $mysqli->stmt_init();

    if ($stmt->prepare("SELECT id, post_name FROM cc_user_register WHERE post_email = ? AND post_password = ?")) {

    	$stmt->bind_param("ss", $email, $password);

      /* execute query */
      $stmt->execute();

    	/* bind your result columns to variables, e.g. id column = $post_id */
      $stmt->bind_result($db_uid, $db_uname);

    	/* store result */
      $stmt->store_result();

    	if($stmt->num_rows){// are there any results?

    	  /* fetch the result of the query & loop round the results */
        while($stmt->fetch()) {

    		$_SESSION['userid'] = $db_uid;
    		$_SESSION['user_name'] = $db_uname;
        }
    	}
      /* close statement */
      $stmt->close();
    }
    /* close connection */
    $mysqli->close();
  }
  header('Location: MyPortal.php?nav_id=5&user_id='.$_SESSION['userid']);
?>
