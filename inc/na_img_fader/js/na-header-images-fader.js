/**
 * @author Marco Herzog
 */
// <![CDATA[
  jQuery(document).ready(function($) {
    
    // variables/objects
    var count = 0; // count header_images
    for (k in header_images) if (header_images.hasOwnProperty(k)) count++;
    var i = 0; // variable for header_images iteration
    var j = 0; // counter for slideshowdivs switch
      
    config = new Object();
    config["delay"] = header_fader_sleep_time;
    config["fadetime"] = parseInt(header_fader_fade_time);
  
    // get value by key out of object
    function getAtFromJson(pos, object, keyname) {
        var counter = 0;
        var result = null;
        $.each(object, function(key,value){ 
            if(counter == pos) {
                result = value[keyname];
                return false;
            };
            counter++;
        });
        return result;
    }
  
    // add slider-divs inside slideshow-stage
    $("#header-stage").prepend($("<div id='header-slider1' class='header-slideshow'>"));
    $("#header-stage").prepend($("<div id='header-slider2' class='header-slideshow'>"));
  
    // set z-index for all divs inside slideshow stage to be above slideshow-divs
    $("#header-stage > *").css({'z-index' : '14'});
    //$("#header-stage > *").css({'position' : 'relative'});
    $("#header-stage > *").each (function () {
      if($(this).css('position').length > 0) {
        $(this).css({'position' : 'relative'})
      };
    });
  
    // set css for slideshow-divs
    var cssObj = {
      'height' : $("#header-stage").css("height"),
      'width' : '100%',
      'position' : 'absolute',
      'top' : 0,
      'left' : 0,
      'z-index' : '11',
      'background-position' : 'center',
      'background-size' : 'cover'
    }
    $(".header-slideshow").css(cssObj).hide();
  
    //fading in background image after loaded src: http://stackoverflow.com/a/977151
      $.fn.smartHeaderImage = function(url){
        var t = this;
        //create an img so the browser will download the image:
        $('<img />')
        .attr('src', url)
        .load(function(){ //attach onload to set background-image
          t.each(function(){ 
            $(this).hide(0,function(){
              $(this).css({'z-index' : '13'});
              $(this).css('backgroundImage', 'url('+url+')' );
              $(this).fadeIn(config["fadetime"],function(){
                $(this).css({'z-index' : '12'});
                $(this).siblings(".header-slideshow").css({'z-index' : '11'});
                setTimeout(headerImgLoop,config["delay"]);
              });
            });
          });
        });
      }
      
    //loop
    function headerImgLoop() {
      //$("#console").append(j + "-" + count + "-" + i + " - ");
      if (j%2 == 0) {
        $("#header-slider1").smartHeaderImage(getAtFromJson(i, header_images, "url"));
      } else {
        $("#header-slider2").smartHeaderImage(getAtFromJson(i, header_images, "url"));
      };
      if (i == count-1) {i = 0} else {i++};
      j++;
    }
    
    // START
    headerImgLoop();
    
    // resize header-slideshow divs
    $("#header-stage").resize(function() {
      var height = $("#header-stage").css("height");
      $('.header-slideshow').css('height',height);
    });
  });
// ]]>