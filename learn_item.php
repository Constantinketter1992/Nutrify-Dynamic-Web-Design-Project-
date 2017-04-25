<?php

/* getConnection() function is in the functions.php that is 'included' at the top */
$mysqli = getConnection();


/* create a prepared statement */
$stmt =  $mysqli->stmt_init();

if ($stmt->prepare("SELECT item_id, title,descr, front_picture, date_item FROM cc_articles GROUP BY RAND() LIMIT 3
						")) {

    /* execute query */
    $stmt->execute();

	/* bind your result columns to variables, e.g. id column = $post_id */
    $stmt->bind_result($item_id, $title, $descr, $front_picture, $date_item);

	/* store result */
    $stmt->store_result();

	if($stmt->num_rows){// are there any results?


	/* fetch the result of the query & loop round the results */
    while($stmt->fetch()) {
			// start the div
			echo "<div class=\"col-sm-6 col-md-4\">\n";
			//generate container
			echo "<div class=\"thumbnail\">\n";
			//  add picture
			echo "<img src=\"img/$front_picture\"  alt=\"...\">\n";

			echo "<div class=\"caption\">\n";

			echo "<h3>$title</h3>\n";

			// add the text
			echo "<p>$descr</p>";

	    echo "<p><a class=\"btn btn-primary\" href=\"detail.php?item_id=$item_id\"role=\"button\">View details</a></p>\n";

			echo "</div>\n\n";
			echo "</div>\n\n";
			echo "</div>\n\n";
	  }

	}
  /* close statement */
  $stmt->close();
}

/* close connection */
$mysqli->close();
?>
