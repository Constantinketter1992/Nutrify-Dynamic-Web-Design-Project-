
//function: show food item suggestions as the user types into the text input field
//the input field has an onkeyup event handler which calls this function
//the string parameter is used to make a search request to the USDA api
//the suggestions returned get displayed in the empty div with the id "txtHint"
//global variables used:
var apiKey = "Q3teVE4iVm6IkMdXw3GUtHD316WGwdarNsFPI5j5"; //USDA api key to access the food database
function showHint(str){
  //first reset the suggestions div
  $("#txtHint").empty();
  //if string is empty do nothing
  if(str.length == 0){
    return;
  }else{
    //parameters passed for the search request
    var name = str;
    var max = '100';
    var sort = 'r';
    var ds = "";

    //url for the get request using a json format
    var url = "http://api.nal.usda.gov/ndb/search/?format=json&q=" + name + "&ds=" + ds + "&max=" + max + "&sort=" + sort + "&api_key=" + apiKey;

    $.get(url, function( data ) {
      //convert returned data value to JSON string
      var list = JSON.stringify(data);
      //convert string to object
      var obj = JSON.parse(list);
      //array to hold food item names
      var arr = [];
      //array to hold food item id's
      var arr_2 = [];
      //var to hold all food item suggestions
      var items = obj.list.item;
      //iterate through all food items and store their names and id's
      //the id's will be used to make another get request to get the nutrient reports
      for(var i=0;i<items.length;i++){
        arr.push(items[i].name);
        arr_2.push(items[i].ndbno);
      }

      //display the suggestions in the txtHint div
      //an onclick event handler is placed on each food item, which calls the showItem function with a parameter of that item's id
      //the showItem function will request the item's nutrients report
      for(var i = 0; i < arr.length; i++){
        $("#txtHint").append("<div class='row line'><div class='col-xs-10'>"+arr[i]+"</div><div class='col-xs-2'><div class='glyphicon glyphicon-plus' onclick='showItem("+arr_2[i]+")'></div></div></div>");
      }
    });
  }
}

//function: if a food item is clicked in the suggestions box:
//make a get request to USDA to acquire the nutrients report for that item's id
//with that report, display the following in the #item_show div:
  //the nutrient values for that food item per 100 grams
  //a select option for the meal type for that food item (e.g. Breakfast)
  //a number input field to change the number of grams
  //a button to submit that food item to the database
//global variables used:
var final = {}; //object that will hold the food item's nutrient information
var food_name = '';
function showItem(food_id){
  //empty the food suggestions div
  showHint("");
  //make a get request to USDA by passing in the food item's id.
  var ndbno = food_id;
  var url = "http://api.nal.usda.gov/ndb/reports/?format=json" + "&ndbno=" + ndbno + "&api_key=" + apiKey;
  $.get(url, function( data ) {
    //convert returned data value to JSON string
    var nutrition_data = JSON.stringify(data);
    //convert JSON string to object
    var obj = JSON.parse(nutrition_data);
    //store nutrients values in a seperate variable
    var nutrients = obj.report.food.nutrients;
    //save item name with the first letter capitalized
    String.prototype.capitalizeFirstLetter = function() {
      return this.charAt(0).toUpperCase() + this.slice(1);
    }
    food_name = obj.report.food.name.toLowerCase().capitalizeFirstLetter();
    //multidimensional array to store each nutrient's name, value and unit: e.g. calories, 100, and kcal
    var arr = [];
    for(var i = 0; i < nutrients.length; i++){
      var array = [];
      array.push(nutrients[i].name);
      array.push(nutrients[i].value);
      array.push(nutrients[i].unit);
      arr.push(array);
    }
    //create a template for the item's nutrients we want to store
    final = {
      energy: [0,"kcal"], carbs: [0,"g"], protein: [0,"g"], fat: [0,"g"], sugar: [0,"g"], unsaturated: [0,"g"], saturated: [0,"g"], cholesterol: [0,"mg"], fiber: [0,"g"], calcium: [0,"mg"], sodium: [0,"mg"]
    };
    //iterate through the multidimensional array to find
    //the nutrients we need and store them in the object template.
    //Each nutrient has an unconventional name e.g. "Total Lipid (fat)" instead of "Fat" therefore a switch statement is used to find the nutrients and their data
    for(var i=0;i<arr.length;i++){
      switch(arr[i][0]){
        case 'Energy':
          final.energy[0] = arr[i][1];
          break;
        case 'Carbohydrate, by difference':
          final.carbs[0] = arr[i][1];
          break;
        case 'Protein':
          final.protein[0] = arr[i][1];
          break;
        case 'Total lipid (fat)':
          final.fat[0] = arr[i][1];
          break;
        case 'Sugars, total':
          final.sugar[0] = arr[i][1];
          break;
        case 'Fatty acids, total saturated':
          final.saturated[0] = arr[i][1];
          final.unsaturated[0] = (parseInt(final.fat)-parseInt(final.saturated)).toString();
          break;
        case 'Cholesterol':
          final.cholesterol[0] = arr[i][1];
          break;
        case 'Fiber, total dietary':
          final.fiber[0] = arr[i][1];
          break;
        case 'Calcium, Ca':
          final.calcium[0] = arr[i][1];
          break;
        case 'Sodium, Na':
          final.sodium[0] = arr[i][1];
          break;
      }
    }
    //empty the #item_show div in case another food item's nutrient values are already displayed
    $('#item_show').empty();

    //fill in the #item_show div with a form of a select option, number input field, and submit button
    //the input field for changing the # of grams will have a onkeyup event handler with a changeValues() function that will change the nutrient values in real time
    //the button will have an onclick event handler with the function addItem() that will allow the food item to be stored on the database through an ajax request without a page reload.
    $('#item_show').append("<form action='' method='post'><input id='#number' type='number' value='100' onkeyup='changeValues(this.value)'> (in grams)<select id='type' name='meal_type'><option value='Snack'>Snack</option><option value='Breakfast'>Breakfast</option><option value='Lunch'>Lunch</option><option value='Dinner'>Dinner</option></select><button onclick='addItem()' type='button' name='submit_item' value='submit'><i class='glyphicon glyphicon-check'></i></button></form>");

    //display each nutrient's name, value, and unit by iterating through var:final
    for(var key in final){
      $('#item_show').append("<div>"+key+": <span id='"+key+"'>"+final[key][0]+"</span>"+final[key][1]+"</div>");
    }
  });
}

//function: if the number of grams are changed in the #item_show div through the onkeyup event,
//the nutrient values will be changed:
function changeValues(num){
  if(num === ""){
    num = "0";
  }
  var $table = $('#item_show').find('span');
  //change nutrient values and update the values displayed
  for(var key in final){
    //calculate new value for the nutrient
    var new_value = (num/100*final[key][0]).toFixed(2);
    //change value displayed
    $table.filter("#"+key).html(new_value);
    //change value stored
    final[key][2]=new_value;
  }
}

var portal_goal = 0; //user's daily target calories and nutrient values
var portal_progress = []; //user's progress for the day (e.g. calories left to eat to achieve goal)
var progress_condition; //whether user has any progress
var portal_values = []; //percentage of target completed

$(document).ready(function(){
  getGoal(function(){
    getProgress(function(){
      calculateValue();
      showBars();
      showItemsFromToday();
    });
  });
});

//function: get user's daily target calories and nutrients from database
//using an ajax get request to the database
//global variables:
var portal_goal = 0; //user's daily target calories and nutrient values
function getGoal(callback){
  var url = "portal_goal.php";
  $.get(url, function( data ) {
    //convert string of values to an array of numbers
    portal_goal = data.split(",").map(Number);
    callback();
  });
}

//function: get user's target progress for the day (e.g. calories left to achieve goal)
//using an ajax get request to the database
function getProgress(callback){
  var url = "portal_progress.php";
  $.get(url, function( data ) {
    if(data == "false"){
      progress_condition = false;
    }else{
      progress_condition = true;
      portal_progress = data.split(",").map(Number);
    }
    callback();
    }
  );
}

//function: calculate user's percentage of calories and nutrients eaten today
function calculateValue(){
  //iterate through the nutrients and add the percentage of nutrients eaten into an array
  for(var i = 0; i < portal_goal.length; i++){
    //if user ate anything today
    if(progress_condition){
      portal_values.push(((portal_goal[i]-portal_progress[i])/portal_goal[i]).toFixed(2));
    }else{
      //add a percentage progress value of 0% for each nutrient
      portal_values.push(0);
      //add a nutrient value of 0 to each nutrient (e.g. 0 calories)
      portal_progress.push(0);
    }
  }
}


//function: draw or update progress bars
//updates the progress bars when a boolean value of true is passed as a parameter
//the animated progress bars are a plugin from https://kimmobrunfeldt.github.io/progressbar.js/
//global variables used:
var progressLines=[['progress_calories'],['progress_carbs'],['progress_protein'],['progress_fiber'],['progress_sugar'],['progress_cholesterol'],['progress_fat'],['progress_saturated'],['progress_unsaturated'],
['progress_calcium'],['progress_sodium']]; // nutrient progress bars with their div classes
var old_values; //previous progress bar values
function showBars(str) {
  old_values = [];
  for(var i = 0; i < progressLines.length; i++){
    old_values.push(progressLines[i][1]);
    progressLines[i][1]=portal_values[i];
    //update progress bar
    if(str){
      //set animation of progress bars with their start and end points
      progressLines[i][2].set(old_values[i]);
      progressLines[i][2].animate(progressLines[i][1]);
    }
    //draw progress bar
    else{
      progressLines[i].push(0);
      createProgressBar(progressLines[i][0],progressLines[i][1],i);
    }
  }
  //colors for animated progress bar
  var startColor = '#B2DBBF';
  var endColor = '#FF1654';
  function createProgressBar(divClass,value,index){
    progressLines[index][2] = new ProgressBar.Line('#'+divClass, {
      strokeWidth: 6,
      color: '#696969',
      trailColor: '#A7A37E',
      trailWidth: 2,
      easing: 'easeInOut',
      duration: 3000,
      svgStyle: null,
      text: {
        value: '',
        alignToBottom: false
      },
      from: {color: '#046380'},
      to: {color: '#002F2F'},
      // Set default step function for all animate calls
      step: function(state, bar){
        bar.path.setAttribute('stroke', state.color);
        var value = Math.round(bar.value() * 100);
        if (value === 0) {
          bar.setText('0%');
        } else {
          bar.setText(value+"%");
        }
      }
    });
    progressLines[index][2].animate(value);
  }
}

//function: show user's food items eaten today
//get request to database to get all food items from today
//food items displayed will be divided into meal types
//each item will have an onlick event handler that will show the item's nutritional values
//global variables
var food_items; //all items and their nutritional values from today
function showItemsFromToday(){
  var url = "portal_items.php";
  $.get(url, function( data ) {
      if(data !== 'false'){
        food_items = JSON.parse(data);
        //show food item names based on their meal type
        for(var i = 0; i < food_items[0].length; i++){
          if(food_items[0][i]=='Snack'){
            $('#snack').append("<div>- "+food_items[1][i]+"</div><div class='glyphicon glyphicon-menu-down' id='"+i+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
          }else if(food_items[0][i]=='Breakfast'){
            $('#breakfast').append("<div>- "+food_items[1][i]+"</div><div class='glyphicon glyphicon-menu-down' id='"+i+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
          }else if(food_items[0][i]=='Lunch'){
            $('#lunch').append("<div>- "+food_items[1][i]+"</div><div class='glyphicon glyphicon-menu-down' id='"+i+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
          }else{
            $('#dinner').append("<div>- "+food_items[1][i]+"</div><div class='glyphicon glyphicon-menu-down' id='"+i+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
          }
        }
    }
    //for each meal type div, if there are no food items displayed, show a text of "No Items"
    $('#r_show .col-xs-12').each(function(){
      if($(this).find('div').length == 0){
        $(this).append("<div style='font-style: italic;'>- No Items</div>");
      }
    });
  });
}
var variable_names = [];
function ItemsDescription(id){
  var $index = $('#'+id).next();
  var $text =$index.prev().prev();
  console.log($index);
  if ($index.find('div').length !==0){
    console.log("hi");
    if($index.is(':visible')){
      $text.css('color','#696969');
    }else{
      $text.css('color','#046380');
    }
    $index.toggle();
  }else{
    $index.css('visibility','visible');
    $text.css('color','#046380');
    variable_names = [["Energy","kcal"],["Carbs","g"],["Protein","g"],["Fat","g"],["Sugar","g"],["Saturated Fat","g"],["Unsaturated Fat","g"],["Cholesterol","mg"],["Fiber","g"],["Sodium","mg"],["Calcium","mg"]];
    console.log(variable_names);
    for(var i=0;i<portal_goal.length;i++){
      $index.append("<div>"+variable_names[i][0]+": "+food_items[i+2][id]+variable_names[i][1]+"</div>");
    }
  }
}//ds

function updateItems(){
  // var newItem_condition;
  if(food_items == null){
    // var cols = 12;
    // for ( var i = 0; i < cols; i++ ) {
    //     food_items.push([]);
    // }
    food_items = [[],[],[],[],[],[],[],[],[],[],[],[],[]];
    console.log(food_items);
  }
  //food_items[0].push("hi");
  for(var i=0;i<portal_item.length;i++){
    // if(!newItem_condition){
      food_items[i].push(portal_item[i]);
    // }else{
    //   food_items[i][0].push(portal_item[i]);
    // }
  }
  console.log(food_items);
  var index = food_items[0].length-1;
  if(type=='Snack'){
    checkEmptyItems("snack");
    $('#snack').append("<div>- "+food_items[1][index]+"</div><div class='glyphicon glyphicon-menu-down' id='"+(index)+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
  }else if(type =='Breakfast'){
    checkEmptyItems("breakfast");
    $('#breakfast').append("<div>- "+food_items[1][index]+"</div><div class='glyphicon glyphicon-menu-down' id='"+(index)+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
  }else if(type == 'Lunch'){
    checkEmptyItems("lunch");
    $('#lunch').append("<div>- "+food_items[1][index]+"</div><div class='glyphicon glyphicon-menu-down' id='"+(index)+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
  }else{
    checkEmptyItems("dinner");
    $('#dinner').append("<div>- "+food_items[1][index]+"</div><div class='glyphicon glyphicon-menu-down' id='"+(index)+"' onclick='ItemsDescription(this.id)'></div><div class='description'></div>");
  }
}
function checkEmptyItems(str){
  if($('#'+str).find('div').length===1){
    $('#'+str).children().remove();
  }
}


var type;
function addItem(){
  type = $('select#type').val();
  $('#item_show').empty();
  console.log(type);
  calculateProgress();
  var url = "post_food.php";
  // console.log(type);
  // console.log(portal_item);
  var post_data = {
    'type': type,
    'name': food_name,
    'calories': portal_item[2],
    'carbs': portal_item[3],
    'protein': portal_item[4],
    'fat': portal_item[5],
    'sugar': portal_item[6],
    'saturated': portal_item[7],
    'unsaturated': portal_item[8],
    'cholesterol': portal_item[9],
    'fiber': portal_item[10],
    'sodium': portal_item[11],
    'calcium': portal_item[12],
    'p_calories': newProgress[0],
    'p_carbs': newProgress[1],
    'p_protein': newProgress[2],
    'p_fat': newProgress[3],
    'p_sugar': newProgress[4],
    'p_saturated': newProgress[5],
    'p_unsaturated': newProgress[6],
    'p_cholesterol': newProgress[7],
    'p_fiber': newProgress[8],
    'p_sodium': newProgress[9],
    'p_calcium': newProgress[10]
  };
  $.post(url,post_data,function(){
    updateItems();
    updateProgress();
  });
}
function updateProgress(){
    progress_condition = true;
    console.log(newProgress);
    portal_progress = [];
    portal_progress = newProgress.splice(0);
    console.log(portal_progress);
    newProgress = [];
    portal_item =[];
    portal_values= [];
    calculateValue();
    showBars(true);
}
var newProgress=[];
var portal_item=[];
function calculateProgress(){
  //console.log(final.energy[2]);
  console.log(portal_item);
  console.log(type);
  portal_item.push(type);
  console.log(portal_item);
  portal_item.push(food_name);
  for(var key in final){
    if(final.energy.length==2){
      portal_item.push(final[key][0]);
    }else{
      portal_item.push(final[key][2]);
    }
  }
  for(var i=0;i<portal_progress.length;i++){
    if(progress_condition){
      newProgress.push((portal_progress[i]-parseInt(portal_item[i+2])).toFixed(2));
    }else{
      newProgress.push(portal_goal[i]-portal_item[i+2]);
    }
  }
}
