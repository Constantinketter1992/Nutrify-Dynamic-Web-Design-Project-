<?php include '../../functions.php'; ?>
<?php
//get connection
$mysqli = getConnection();

$user_id = $_SESSION['userid'];

//GET USER PROGRESS
/* create a prepared statement */
$stmt =  $mysqli->stmt_init();

if ($stmt->prepare("SELECT progress_calories, progress_carbs, progress_fiber,
          progress_sugar, progress_protein, progress_fat, progress_saturated, progress_unsaturated, progress_cholesterol, progress_sodium, progress_calcium FROM cc_user_progress WHERE user_id=$user_id AND DATE(post_date) = CURDATE() ORDER BY post_date DESC LIMIT 1
          ")) {

  /* execute query */
    $stmt->execute();

  /* bind your result columns to variables, e.g. id column = $post_id */
    $stmt->bind_result($progress_calories, $progress_carbs, $progress_fiber, $progress_sugar, $progress_protein, $progress_fat, $progress_saturated, $progress_unsaturated, $progress_cholesterol, $progress_sodium, $progress_calcium);

  /* store result */
    $stmt->store_result();

    if($stmt->num_rows){// are there any results?

    /* fetch the result of the query & loop round the results */
      while($stmt->fetch()) {
      // add the options
      $carbs_progress = $progress_carbs;
      $calories_progress = $progress_calories;
      $fiber_progress = $progress_fiber;
      $sugar_progress = $progress_sugar;
      $protein_progress = $progress_protein;
      $fat_progress = $progress_fat;
      $saturated_progress = $progress_saturated;
      $unsaturated_progress =  $progress_unsaturated;
      $cholesterol_progress = $progress_cholesterol;
      $sodium_progress = $progress_sodium;
      $calcium_progress = $progress_calcium;

      }
      $progress_array = "$progress_calories,$progress_carbs,$progress_protein,$progress_fat,$progress_sugar,$progress_saturated,$progress_unsaturated,$progress_cholesterol,$progress_fiber,$progress_sodium,$progress_calcium";

    }else {
      $progress_array = "false";
    }
    /* close statement */
    $stmt->close();
  }


/* close connection */
$mysqli->close();


echo $progress_array;

?>
