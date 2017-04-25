$(document).ready(function() {
  var $wizard = $('#wizard');
  var $tabs = $wizard.find('.tabs');
  var $tab = $tabs.find('li');
  //var $tab_active = $tabs.find('li.active');
  var $contents = $wizard.find('.tab-content');
  var $content = $contents.find('.content');
  //var $content_active = $wizard.find('.content.active');
  var $button = $wizard.find('#buttons li');
  //last active one:
  var $last_active=$content.filter('.active');
  var $last_content_items = $last_active.find("input[data-validation]").not("[data-validation='confirmation']");

  $tab.on('click', function() {
      var $tab_active = $tab.filter('.active');

      if($last_content_items.parent().siblings().filter('.has-success').length == $last_content_items.length || $last_content_items===0){
        $tab_active.removeClass('active').children().toggleClass('success');

        $(this).addClass('active').children().removeClass('success');

        //content to show
        var $content = $(this).children().attr('href');

        //hide current content
        $last_active.slideUp(500, showNextContent);

        //reset last items:
        $last_active = $($content);
      $last_content_items = $($content).find("input[data-validation]").not("[data-validation='confirmation']");

      }else{
        alert("please fill in all required fields");
      }
      //show next panel
      function showNextContent() {
          $(this).removeClass('active');

          $($content).slideDown(1000, function() {
              $(this).addClass('active');
          });
      }

  });

  $button.on('click', function(){
    var $tab_active = $tab.filter('.active');
    if($last_content_items.parent().siblings().filter('.has-success').length == $last_content_items.length || $last_content_items===0){

      if($(this).hasClass("previous")){
        if($last_active.index() > 0){
          $tab_active.removeClass('active').children().toggleClass('success').parent().prev().addClass('active').children().removeClass('success');

          $last_active.slideUp(500, showPreviousContent);
        }
      }
      if($(this).hasClass("next")){
        if($last_active.index() < $content.length-1){
          $tab_active.removeClass('active').children().toggleClass('success').parent().next().addClass("active").children().removeClass('success');
          $last_active.slideUp(500, showNextContent);
        }
      }
    }else{
      alert("please fill in all required fields");
    }

    function showNextContent() {
        $(this).removeClass('active');

        $(this).next().slideDown(1000, function() {
            $(this).addClass('active');
            $last_active = $(this);
            $last_content_items = $last_active.find("input[data-validation]").not("[data-validation='confirmation']");

        });
    }
    function showPreviousContent() {
        $(this).removeClass('active');

        $(this).prev().slideDown(1000, function() {
            $(this).addClass('active');
            $last_active = $(this);
            $last_content_items = $last_active.find("input[data-validation]").not("[data-validation='confirmation']");
        });
    }
  });
});
