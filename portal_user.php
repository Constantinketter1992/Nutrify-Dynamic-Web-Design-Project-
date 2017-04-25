<?php
  //get connection
  $mysqli = getConnection();
  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();

  $user_id = $_SESSION['userid'];

  if ($stmt->prepare("SELECT post_gender, post_age, post_weight, post_height FROM cc_user_profile WHERE user_id=$user_id
  					")) {

//	  $_SESSION['userid']

    /* execute query */
      $stmt->execute();

  	/* bind your result columns to variables, e.g. id column = $post_id */
      $stmt->bind_result($post_gender, $post_age, $post_weight, $post_height);

  	/* store result */
      $stmt->store_result();

  	if($stmt->num_rows){// are there any results?

  	/* fetch the result of the query & loop round the results */
      while($stmt->fetch()) {
  		// add the options
		$gender = $post_gender;
		$age = $post_age;
		$weight = $post_weight;
		$height = $post_height;
    //$pic = $profile_pic;

  	  }

  	}
    /* close statement */
    $stmt->close();

  }
  /* close connection */
  $mysqli->close();
?>

<?php
  //get connection
  $mysqli = getConnection();
  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("SELECT post_name FROM cc_user_register WHERE id=$user_id
  					")) {

//	  $_SESSION['userid']

    /* execute query */
      $stmt->execute();

  	/* bind your result columns to variables, e.g. id column = $post_id */
      $stmt->bind_result($post_name);

  	/* store result */
      $stmt->store_result();

  	if($stmt->num_rows){// are there any results?

  	/* fetch the result of the query & loop round the results */
      while($stmt->fetch()) {
  		// add the options
		  $name = $post_name;

    }

  	}
    /* close statement */
    $stmt->close();
  }
  /* close connection */
  $mysqli->close();
?>
