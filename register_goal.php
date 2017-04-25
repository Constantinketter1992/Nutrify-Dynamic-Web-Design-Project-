
<?
  //get connection
  $mysqli = getConnection();
  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("SELECT id, goal_type, goal_mult FROM cc_cat_goal")) {

    /* execute query */
      $stmt->execute();

  	/* bind your result columns to variables, e.g. id column = $post_id */
      $stmt->bind_result($goal_id, $goal_description, $goal_mult);

  	/* store result */
      $stmt->store_result();

  	if($stmt->num_rows){// are there any results?

  	/* fetch the result of the query & loop round the results */
      while($stmt->fetch()) {
  		// add the options
  		echo "<option value=\"$goal_id,$goal_mult\" >$goal_description</option>\n";
  	  }
  	}
    /* close statement */
    $stmt->close();
  }
  /* close connection */
  $mysqli->close();
?>
