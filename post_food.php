<!-- Food Item  -->

<?php include '../../functions.php'; ?>
<?
$mysqli = getConnection();
$user_id = $_SESSION['userid'];

  //declare paramaters
  $post_meal_type = $_POST['type'];
  $post_food_name=$_POST['name'];
  $post_food_calories=$_POST['calories'];
  $post_food_carbs=$_POST['carbs'];
  $post_food_protein=$_POST['protein'];
  $post_food_fats=$_POST['fat'];
  $post_food_sugar=$_POST['sugar'];
  $post_food_saturated=$_POST['saturated'];
  $post_food_unsaturated=$_POST['unsaturated'];
  $post_food_cholesterol=$_POST['cholesterol'];
  $post_food_fiber=$_POST['fiber'];
  $post_food_sodium=$_POST['sodium'];
  $post_food_calcium=$_POST['calcium'];
  $progress_calories = $_POST['p_calories'];
  $progress_carbs = $_POST['p_carbs'];
  $progress_fiber = $_POST['p_fiber'];
  $progress_sugar = $_POST['p_sugar'];
  $progress_protein = $_POST['p_protein'];
  $progress_fat = $_POST['p_fat'];
  $progress_saturated = $_POST['p_saturated'];
  $progress_unsaturated = $_POST['p_unsaturated'];
  $progress_cholesterol = $_POST['p_cholesterol'];
  $progress_sodium = $_POST['p_sodium'];
  $progress_calcium = $_POST['p_calcium'];

  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("INSERT INTO cc_user_intake (user_id, post_meal_type, post_food_name, post_food_calories, post_food_carbs, post_food_protein, post_food_fat, post_food_sugar, post_food_saturated, post_food_unsaturated, post_food_cholesterol, post_food_fiber, post_food_sodium, post_food_calcium, post_date)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())")){

     //bind parameters
     $stmt->bind_param("issiiiiiiiiiii", $user_id, $post_meal_type, $post_food_name, $post_food_calories, $post_food_carbs, $post_food_protein, $post_food_fats, $post_food_sugar, $post_food_saturated, $post_food_unsaturated, $post_food_cholesterol, $post_food_fiber, $post_food_sodium, $post_food_calcium);

     //execute query
     $stmt->execute();

     /* close statement */
     $stmt->close();
  }

  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("INSERT INTO cc_user_progress (user_id, food_name, progress_calories, progress_carbs, progress_fiber,
            progress_sugar, progress_protein, progress_fat, progress_saturated, progress_unsaturated, progress_cholesterol, progress_sodium, progress_calcium, post_date)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())")){

     //bind parameters
     $stmt->bind_param("isiiiiiiiiiii", $user_id, $post_food_name, $progress_calories, $progress_carbs, $progress_fiber, $progress_sugar, $progress_protein, $progress_fat, $progress_saturated, $progress_unsaturated, $progress_cholesterol, $progress_sodium, $progress_calcium);


     //execute query
     $stmt->execute();

     /* close statement */
     $stmt->close();
  }

  /* close connection */
  $mysqli->close();
//}
?>
