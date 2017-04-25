<!-- connect to database and grab footer tab names and links -->
<!-- made for three tabs but can be easily changed using bootstraps grid system -->
<?php

  $mysqli = getConnection();

  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("SELECT tab_name, link
  					FROM cc_footer_tabs
  					")) {

      /* execute query */
      $stmt->execute();

  	/* bind your result columns to variables, e.g. id column = $post_id */
      $stmt->bind_result($tab_name, $tab_link);

  	/* store result */
      $stmt->store_result();

  	if($stmt->num_rows){// are there any results?

  	  /* fetch the result of the query & loop round the results */
      while($stmt->fetch()) {
    		echo "<div class='col-xs-4'><a href =\"$tab_link\">$tab_name</a></div>";
  	  }
  	}

    /* close statement */
    $stmt->close();
  }

  /* close connection */
  $mysqli->close();

?>
