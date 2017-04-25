
<?php include '../../functions.php'; ?>
<html>

  <head>
    <?php include 'metadata_inc.php'; ?>
    <script type="text/javascript" src="js/myPortal.js"></script>
  </head>

  <body>

    <?php include 'navbar.php'; ?>
    <?php include 'portal_user.php'; ?>
    <?php include 'portal_goal_2.php'; ?>


    <div class="container-fluid myportal">

      <div class="row">
        <!-- LEFT SIDE -->
        <div id="left" class="col-sm-4 col-xs-12">
          <!-- 1st ROW: USER IMAGE AND INFO-->
          <div class="row corner">
            <!-- IMAGE -->
            <div class="col-xs-4">

              <div class="CharImg">
                <img src="img/User.png" />
              </div>
            </div>
            <!-- INFO -->
            <div id='info' class="col-sm-8 col-xs-12 corner">
              <h1><strong></strong> <?php echo $name ?></h1>
              <p><strong>- Gender:</strong>  <?php echo $gender ?></p>
              <p><strong>- Age: </strong>  <?php echo $age ?></p>
              <p><strong>- Weight:</strong>  <?php echo $weight ?> kg</p>
              <p><strong>- Height:</strong>  <?php echo $height ?> cm</p>
            </div>
          </div>

          <!-- 2nd ROW: SEARCH DATABASE  -->
          <div class="row corner">
            <div class="col-xs-12">
              <div id='s_db' class="row">
                  <input type="text" onkeyup="showHint(this.value)" size="20" placeholder="Search Food Item" />
                  <div class="col-xs-12" id="txtHint"></div>
              </div>
            </div>
          </div>
          <!-- 3rd ROW: SHOW AND ADD FOOD ITEM -->
          <div id="item_show" class="row corner">
            <!-- whatever is shown from databse(done in JS) -->
          </div>

          <!-- 4th ROW: FOOD ITEMS LIST -->
          <div id="r_show" class="row corner">
            <div id="snack" class="col-xs-12 ">Snacks</div>
            <div id="breakfast" class=" col-xs-12">Breakfast</div>
            <div id="lunch" class="col-xs-12 ">Lunch</div>
            <div id="dinner" class="col-xs-12 ">Dinner</div>
          </div>
        </div>
        <!-- END OF LEFT SIDE -->


      <!-- Progress bars obtained from: https://kimmobrunfeldt.github.io/progressbar.js/ -->

        <!-- RIGHT SIDE -->
        <div class="col-sm-8 col-xs-12">

          <!-- 1st ROW: calories -->
          <div class="row">
            <div class="col-xs-12 corner">
              <h4>Calories</h4>
              <p id='target_tag'>target: <? echo $calories_goal ?> calories </p>
              <div id="progress_calories" value='24'></div>
            </div>
          </div>

          <!-- 2nd ROW: carbs,protein -->
          <div class="row">
            <!-- Carbs -->
            <div class="col-sm-6 col-xs-12 corner">
                <h4>Carbohydrates</h4>
                <p>target: <? echo $carbs_goal ?> g </p>
                <div id="progress_carbs" value='90'></div>
            </div>
            <!-- Protein -->
            <div class="col-sm-6 col-xs-12 corner">
                <h4>Protein</h4>
                <p>target: <? echo $protein_goal ?> g </p>
                <div id="progress_protein"></div>
            </div>
          </div>

          <!-- 3rd ROW: fat, sugar -->
          <div class="row">
            <!-- FAT -->
            <div class="col-sm-6 col-xs-12 corner">
              <h4>Fat</h4>
              <p>target: <? echo $fat_goal ?> g </p>
              <div id="progress_fat"></div>
            </div>
            <!-- SUGAR -->
            <div class="col-sm-6 col-xs-12 corner">
              <h4>Sugar</h4>
              <p>target: <? echo $sugar_goal ?> g</p>
              <div id="progress_sugar"></div>
            </div>
          </div>

          <!-- 4th ROW: saturated, unsaturated, cholesterol  -->
          <div class="row">
            <!-- saturated -->
            <div class="col-sm-4 col-xs-12 corner">
              <h4>Saturated Fat</h4>
              <p>target: <? echo $saturated_goal ?> g </p>
              <div id="progress_saturated"></div>
            </div>
            <!-- unsaturated -->
            <div class="col-sm-4 col-xs-12 corner">
              <h4>Unsaturate Fat</h4>
              <p>target: <? echo $unsaturated_goal ?> g </p>
              <div id="progress_unsaturated"></div>
            </div>
            <!-- CHOLESTEROL -->
            <div class="col-sm-4 col-xs-12 corner">
              <h4>Cholesterol</h4>
              <p>target: <? echo $cholesterol_goal ?> mg</p>
              <div id="progress_cholesterol"></div>
            </div>
          </div>

          <!-- 5th ROW: fiber, sodium, potassium,  -->
          <div class="row">
            <!-- FIBER -->
            <div class="col-sm-4 col-xs-12 corner">
              <h4>Fiber</h4>
              <p>target: <? echo $fiber_goal ?> g</p>
              <div id="progress_fiber"></div>
            </div>
            <!-- SODIUM -->
            <div class="col-sm-4 col-xs-12 corner">
              <h4>Sodium</h4>
              <p>target: <? echo $sodium_goal ?> mg </p>
              <div id="progress_sodium"></div>
            </div>
            <!-- POTASSIUM -->
            <div class="col-sm-4 col-xs-12 corner">
              <h4>Calcium</h4>
              <p>target: <? echo $calcium_goal ?> mg </p>
              <div id="progress_calcium"></div>
            </div>
          </div>
        </div>

      <!-- END OF RIGHT SIDE -->
      </div>
    <!-- END OF CONTAINER -->
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://cdn.rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>

  </body>
</html>
