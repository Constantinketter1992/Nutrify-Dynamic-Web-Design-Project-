<!-- connect to database and grab tab names and links -->
<?php

  $mysqli = getConnection();

  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("SELECT tab_name, link
  					FROM cc_navigation_tabs
  					")) {

      /* execute query */
      $stmt->execute();

  	/* bind your result columns to variables, e.g. id column = $post_id */
      $stmt->bind_result($tab_name, $link);

  	/* store result */
      $stmt->store_result();

  	if($stmt->num_rows){// are there any results?
      //variable for keeping track of row number in num_rows: used in while loop
      $i = 0;
  	  /* fetch the result of the query & loop round the results */
      while($stmt->fetch()) {
  		echo "<li><a href =\"$link\">$tab_name</a></li>\n";
      $i++;
  	  }
  	}

    /* close statement */
    $stmt->close();
  }

  /* close connection */
  $mysqli->close();

?>
