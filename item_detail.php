<?php

// first set a default value, just in case it can't be found in the URL
$item_id = 0;
// now try to get it in the URL
$item_id = $_GET['item_id'];

/* getConnection() function is in the functions.php that is 'included' at the top */
$mysqli = getConnection();

// Retrieve JUST the product details

/* create a prepared statement */
$stmt =  $mysqli->stmt_init();

if ($stmt->prepare("SELECT item_id, title, descr, front_picture, date_item, author, art, art_picture FROM cc_articles
					WHERE cc_articles.item_id = ?
					")) {

	$stmt->bind_param("i", $item_id);

    /* execute query */
    $stmt->execute();

	/* bind your result columns to variables, e.g. id column = $post_id */
    $stmt->bind_result($item_id, $title, $descr, $front_picture, $date_item, $author, $art, $art_picture );

	/* store result */
    $stmt->store_result();

	if($stmt->num_rows){// are there any results?


	/* fetch the result of the query & loop round the results */
    while($stmt->fetch()) {
		// start the div
		echo "<div class=\"container charts\">\n";
		//add front picture
		echo "<img id=\"artPicF\" src=\"img/$front_picture\"  alt=\"...\">\n";
		// add the title
		echo "<h1>$title</h1>\n";
		//add author
		echo "<h4>$author</h4>\n";
		//add date
		echo "<p>$date_item </p>\n";
		// add the text
		echo "<h3>$descr</h3>";
		//add art picture
		echo "<img id=\"artPicA\" src=\"img/$art_picture\"  alt=\"...\">\n";

		echo "<p>$art</p>";

		// close the div
		echo "</div>\n\n";
	  	}

	}

  /* close statement */
  $stmt->close();

}
/* close connection */
$mysqli->close();
?>
