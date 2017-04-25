

<?php
  //get connection
  $mysqli = getConnection();

  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("SELECT id, medical_condition FROM cc_cat_medical")) {

    $stmt->execute();

    $stmt->bind_result($med_id, $med_condition);

    $stmt->store_result();

  	if($stmt->num_rows){// are there any results?

    	/* fetch the result of the query & loop round the results */
      while($stmt->fetch()){

        echo "<li><input type='checkbox' name='checkboxes[]' value='".$med_id."'/> ".$med_condition."</li>\n";

      }
  	}
    /* close statement */
    $stmt->close();
  }
  /* close connection */
  $mysqli->close();
?>
