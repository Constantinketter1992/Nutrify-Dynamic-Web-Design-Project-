<?php include '../../functions.php'; ?>
<?php
  //get connection
  $mysqli = getConnection();

  //GET USER GOAL
  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();
  $user_id = $_SESSION['userid'];

  if ($stmt->prepare("SELECT post_carbs, post_calories, post_fiber,
            post_sugar, post_protein, post_fat, post_saturated, post_unsaturated, post_cholesterol, post_sodium, post_calcium FROM cc_user_plan WHERE user_id=$user_id
            ")) {

    /* execute query */
      $stmt->execute();

    /* bind your result columns to variables, e.g. id column = $post_id */
      $stmt->bind_result($goal_carbs, $goal_calories, $goal_fiber, $goal_sugar, $goal_protein, $goal_fat, $goal_saturated, $goal_unsaturated, $goal_cholesterol, $goal_sodium, $goal_calcium);

    /* store result */
      $stmt->store_result();

      if($stmt->num_rows){// are there any results?

    	/* fetch the result of the query & loop round the results */
        while($stmt->fetch()) {
    		// add the options
        $carbs_goal = $goal_carbs;
        $calories_goal = $goal_calories;
        $fiber_goal = $goal_fiber;
        $sugar_goal = $goal_sugar;
        $protein_goal = $goal_protein;
        $fat_goal = $goal_fat;
        $saturated_goal = $goal_saturated;
        $unsaturated_goal =  $goal_unsaturated;
        $cholesterol_goal = $goal_cholesterol;
        $sodium_goal = $goal_sodium;
        $calcium_goal = $goal_calcium;

    	  }

    	}

  }
  /* close statement */
  $stmt->close();

  /* close connection */
  $mysqli->close();
  $goal_array =
  "$goal_calories,$goal_carbs,$goal_protein,$goal_fat,$goal_sugar,$goal_saturated,$goal_unsaturated,$goal_cholesterol,$goal_fiber,$goal_sodium,$goal_calcium";
  echo $goal_array;
?>
