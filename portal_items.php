<?php include '../../functions.php'; ?>
<?php
//get connection
$mysqli = getConnection();

$user_id = $_SESSION['userid'];
$array = array(array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array());

//GET USER PROGRESS
/* create a prepared statement */
$stmt =  $mysqli->stmt_init();

if ($stmt->prepare("SELECT post_meal_type, post_food_name, post_food_calories, post_food_carbs, post_food_protein, post_food_fat, post_food_sugar, post_food_saturated, post_food_unsaturated, post_food_cholesterol, post_food_fiber, post_food_sodium, post_food_calcium FROM cc_user_intake WHERE user_id=$user_id AND DATE(post_date) = CURDATE() ORDER BY post_date DESC
          ")) {

  /* execute query */
    $stmt->execute();

  /* bind your result columns to variables, e.g. id column = $post_id */
    $stmt->bind_result($meal, $name, $calories, $carbs, $protein, $fat, $sugar, $saturated, $unsaturated, $cholesterol, $fiber, $sodium, $calcium);

  /* store result */
    $stmt->store_result();

    if($stmt->num_rows){// are there any results?
    /* fetch the result of the query & loop round the results */
      while($stmt->fetch()) {
      // add the options
      array_push($array[0],strval($meal));
      array_push($array[1],strval($name));
      array_push($array[2],strval($calories));
      array_push($array[3],strval($carbs));
      array_push($array[4],strval($protein));
      array_push($array[5],strval($fat));
      array_push($array[6],strval($sugar));
      array_push($array[7],strval($saturated));
      array_push($array[8],strval($unsaturated));
      array_push($array[9],strval($cholesterol));
      array_push($array[10],strval($fiber));
      array_push($array[11],strval($sodium));
      array_push($array[12],strval($calcium));

      }
      // for($i = 0; $i < count($array); $i++){
      //   $array_string[] = implode(",",$array[$i]);
      // }
      //echo $array_string;
      echo json_encode($array);

    }else{
      echo "false";
    }
    /* close statement */
    $stmt->close();
  }else{
    echo "false";
  }

/* close connection */
$mysqli->close();


?>
