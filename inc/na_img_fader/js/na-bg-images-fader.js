/**
 * @author Marco Herzog
 */
// <![CDATA[
  jQuery(document).ready(function($) {
    
    // variables/objects
    var count = 0; // count bg_images
    for (k in bg_images) if (bg_images.hasOwnProperty(k)) count++;
    var i = 0; // variable for bg_images iteration
    var j = 0; // counter for slideshowdivs switch
      
    configbg = new Object();
    configbg["delay"] = bg_fader_sleep_time;
    configbg["fadetime"] = parseInt(bg_fader_fade_time);
  
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
    $("body").append($("<div id='body-slider1' class='body-slideshow'>"));
    $("body").append($("<div id='body-slider2' class='body-slideshow'>"));
  
    // set z-index for all divs inside slideshow stage to be above slideshow-divs
    $("body > div#stage").css({'z-index' : '4'});
  
    // set css for slideshow-divs
    var cssObj = {
      'height' : window.innerHeight,
      'width' : '100%',
      'position' : 'fixed',
      'top' : 0,
      'left' : 0,
      'z-index' : '1',
      'background-position' : 'center',
      'background-size' : 'cover'
    }
    $(".body-slideshow").css(cssObj).hide();
  
    //fading in background image after loaded src: http://stackoverflow.com/a/977151
      $.fn.smartBackgroundImage = function(url){
        var t = this;
        //create an img so the browser will download the image:
        $('<img />')
        .attr('src', url)
        .load(function(){ //attach onload to set background-image
          t.each(function(){ 
            $(this).hide(0,function(){
              $(this).css({'z-index' : '3'});
              $(this).css('backgroundImage', 'url('+url+')' );
              $(this).fadeIn(configbg["fadetime"],function(){
                $(this).css({'z-index' : '2'});
                $(this).siblings(".body-slideshow").css({'z-index' : '1'});
                setTimeout(bgImgLoop,configbg["delay"]);
              });
            });
          });
        });
      }
      
    //loop
    function bgImgLoop() {
      //$("#console").append(j + "-" + count + "-" + i + " - ");
      if (j%2 == 0) {
        $("#body-slider1").smartBackgroundImage(getAtFromJson(i, bg_images, "url"));
      } else {
        $("#body-slider2").smartBackgroundImage(getAtFromJson(i, bg_images, "url"));
      };
      if (i == count-1) {i = 0} else {i++};
      j++;
    }
    
    // START
    bgImgLoop();
    
    // resize body-slideshow divs
    $(window).resize(function() {
      var height = window.innerHeight;
      $('.body-slideshow').css('height',height);
    });
  });
// ]]>