<?php include '../../functions.php'; ?>
<?php

  if(isset($_POST['submit_register'])){ //check to see if form was submitted
    $mysqli = getConnection();

    //FIRST: post user registry
    //assign parameters values name,email, and password from form fields
    $post_name =filter_var($_POST['post_name'],FILTER_SANITIZE_STRING);
    $_SESSION['user_name'] = $post_name;
    $post_email = filter_var($_POST['post_email'], FILTER_SANITIZE_EMAIL);
    $post_password = $_POST['post_password'];

    /* create a prepared statement */
    $stmt =  $mysqli->stmt_init();

    if ($stmt->prepare("INSERT INTO cc_user_register (post_name, post_email, post_password, post_date)
     VALUES (?,?,?,NOW())")){

       //bind parameters
       $stmt->bind_param("sss", $post_name, $post_email, $post_password);

       //execute query
       $stmt->execute();

       /* close statement */
       $stmt->close();
    }
    //get last cc_register ID
    $user_id = $mysqli->insert_id;
    $_SESSION['userid'] = $user_id;

    //SECOND: post user PROFILE
    //assign parameters
    $post_gender = filter_var($_POST['post_gender'], FILTER_SANITIZE_STRING);
    $post_age = filter_var($_POST['post_age'], FILTER_SANITIZE_NUMBER_INT);
    $post_weight = filter_var($_POST['post_weight'], FILTER_SANITIZE_NUMBER_INT);
    $post_height = filter_var($_POST['post_height'], FILTER_SANITIZE_NUMBER_INT);
    $post_bf = 0;
    $post_bf = $_POST['post_bf'];

    //seperate activity data-value into two seperate strings: id and multipler
    $data = $_POST['post_activity'];
    list($data1, $data2) = explode(",", $data);
    $post_activity_id = intval($data1);
    $activity_multiplier = floatval($data2);



    //calculate Basal Metabolic Rate (calories)
    if($post_bf == 0){ //if BF is not known use this formula
      if($post_gender == "male"){
        $post_BMR = (10*$post_weight)+(6.25*$post_height)-(5*$post_age)+5;
      } else{
        $post_BMR = (10*$post_weight)+(6.25*$post_height)-(5*$post_age)-161;
      }
    } else{ //if BF is known use this formula
      $post_BMR = 370+(21.6*(100-$post_bf)/100*$post_weight);
    }
    //calculate Total Daily Energy Expenditure(BMR*activity level)
    $post_TDEE = $post_BMR*$activity_multiplier;

    /* create a prepared statement */
    $stmt =  $mysqli->stmt_init();

    if ($stmt->prepare("INSERT INTO cc_user_profile (user_id, post_gender, post_age, post_weight, post_height, post_bf, post_activity_id, post_BMR, post_TDEE)
     VALUES (?,?,?,?,?,?,?,?,?)")){

       //bind parameters
       $stmt->bind_param("isiiidiii", $user_id, $post_gender, $post_age, $post_weight, $post_height, $post_bf, $post_activity_id, $post_BMR, $post_TDEE);

       //execute query
       $stmt->execute();

       /* close statement */
       $stmt->close();
    }



    //THIRD: post MEDICAL
    // count the number of selected objects
    $post_medical_id = $_POST['checkboxes'];
    $cb = count($post_medical_id);// same as myArray.length()

    /* create a prepared statement */
    $stmt =  $mysqli->stmt_init();

    if ($stmt->prepare("INSERT INTO cc_user_medical (user_id, post_medical_id)
     VALUES (?,?)")) {

    	// we loop around our array of id's to populate the ?
    	for($i = 0; $i < $cb; $i++){

    	   /* bind parameters for ? markers, in this integer id */
        $stmt->bind_param("ii", $user_id , $post_medical_id[$i]);

        /* execute query */
        $stmt->execute();
    	}
      /* close statement */
      $stmt->close();
    }

    //FOURTH: post GOALS

    //parameters
    $data_goal = $_POST['post_goal'];
    list($data1_goal, $data2_goal) = explode(",", $data_goal);
    $post_goal_id = intval($data1_goal);
    $mult_goal = floatval($data2_goal)/7;  //divide by 7 to get kg/day
    /* create a prepared statement */
    $stmt =  $mysqli->stmt_init();

    if ($stmt->prepare("INSERT INTO cc_user_goal (user_id, post_goal_id)
     VALUES (?,?)")) {

    	/* bind parameters for ? markers, in this integer id */
      $stmt->bind_param("ii", $user_id , $post_goal_id);

      /* execute query */
      $stmt->execute();
      /* close statement */
      $stmt->close();
    }



  //POST plan: daily target of calories, carbs, protein etc.

  //parameters:
  //use multiplier to calculate calories/day based on goal(e.g. lose 1kg/wk)
  //converting kg/day to calories/day: multiplier
  $goal_cal = $mult_goal * 7000;
  $post_calories = $post_TDEE + $goal_cal;
  //now use the users input to determine diet type: %carbs/protein/fat
  //can either be: 40/40/20, 35/45/20, or 45/30/25
  if($post_goal_id == 3){ //muscle building diet
    $mult_carb = 35;
    $mult_protein = 45;
    $mult_fat = 20;
  }elseif($post_goal_id == 4){ //health diet
    $mult_carb = 45;
    $mult_protein = 30;
    $mult_fat = 25;
  }else{   //fat loss diet
    $mult_carb = 40;
    $mult_protein = 40;
    $mult_fat = 20;
  }

  //calculate carb, protein, fat target (in grams)
  // 1g of carb/protein and fat has 4 calories and 9 calories, respectively.
  $post_carbs = $post_calories/4 * $mult_carb/100;
  $post_protein = $post_calories/4 * $mult_protein/100;
  $post_fat = $post_calories/9 * $mult_fat/100;

  //calculate saturated fat: depends on body weight and goal
  if($post_goal_id == 3){
    $saturatedFat_percentage = 0.06;  //7% for building muscle
  }else{
    $saturatedFat_percentage = 0.04;  //5% for everything else
  }
  $post_saturatedFat = $post_calories * $saturatedFat_percentage/9;
  $post_unsaturatedFat = $post_fat - $post_saturatedFat;

  //calculate fiber: depends on bodyweight and goal
  //14g for every 1000 calories recommended
  if($post_goal_id != 4){ //every goal other than healthy
    $fiber_percentage = 0.056; //6% is 14g / 1000 calories
  }else{
    $fiber_percentage = 0.08;   //for super healthy diet eat 8% fiber
  }
  $post_fiber = $fiber_percentage*$post_calories/4; //in grams

  //calculate sugar: depends on calories, medical conditions, and goal
  if($post_goal_id == 3){ //muscle hypertrophy goal
    $sugar_percentage = 0.06;
  }else{ //every other goal
    $sugar_percentage = 0.03;
  }
  if(in_array(1, $post_medical_id)){  //medical condition overwrite
    $sugar_percentage = 0.015;
  }
  $post_sugar = $sugar_percentage*$post_calories/4;

  //calculate cholesterol
  if($post_goal_id == 3){ //muscle hypertrophy goal
    $post_cholesterol = 350;
  }elseif($post_goal_id == 4){ //healthy diet
    $post_cholesterol = 200;
  }else{
    $post_cholesterol = 250;
  }
  if(in_array(3, $post_medical_id)){  //medical condition overwrite
    $post_cholesterol = 200;
  }

  //calculate sodium
  if($post_goal_id == 4 || in_array(1, $post_medical_id) || in_array(2, $post_medical_id)){
    $post_sodium = 1500;
  }else{
    $post_sodium = 2300;
  }

  //calcium
  if($post_age<=18){
    $post_calcium = 1300;
  }elseif($post_age>=51){
    $post_calcium = 1200;
  }else{
    $post_calcium = 1000;
  }


  /* create a prepared statement */
  $stmt =  $mysqli->stmt_init();

  if ($stmt->prepare("INSERT INTO cc_user_plan (user_id, post_calories, post_carbs, post_fiber, post_sugar, post_protein, post_fat, post_saturated, post_unsaturated, post_cholesterol, post_sodium, post_calcium)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")) {

    /* bind parameters for ? markers, in this integer id */
    $stmt->bind_param("iiiiiiiiiiii", $user_id , $post_calories, $post_carbs, $post_fiber, $post_sugar, $post_protein, $post_fat, $post_saturatedFat, $post_unsaturatedFat, $post_cholesterol, $post_sodium, $post_calcium);

    /* execute query */
    $stmt->execute();
    /* close statement */
    $stmt->close();
  }
  header("Location: MyPortal.php?nav_id=5&user_id=".$_SESSION['userid']);
  /* close connection */
  $mysqli->close();
}else{
  echo "Error";
}
?>
