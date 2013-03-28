function naviAdjust() {

  var fix = function() {
    var navi = $("#main-navigation");
    var cssnavifixed = {position : "fixed",top : "0px",left : "0px",width : "100%","z-index" : "999"};
    var cssnavifixedreset = {position : "relative",top : ""};

    if (status == "normal") {
      navi.css(cssnavifixedreset);
      $(navibrand).hide('200');
    } else {
      navi.css(cssnavifixed);
    }
  };

  var adjustcontent = function() {
    var content = $("#main");
    var csscontentcorrection = {marginTop : '70px'};
    var csscontentcorrectionreset = {marginTop : '0px'};

    if (status == "normal") {
      content.css(csscontentcorrectionreset);
    } else {
      content.css(csscontentcorrection);
    }
  };
  
  var togglebrand = function() {
    animatingbrand = true;
    //$('#console').append('animatingbrand: '+animatingbrand+'<br/>');
    if (status == "normal") {
      $(navibrand).animate({
        left : sum
        },{
          easing: 'linear',
          duration: 200,
          complete: function(){
            $(navibrand).hide();
            animatingbrand = false;
            //$('#console').append('animatingbrand: '+animatingbrand+'<br/>');
            //$('#console').append('navibrand.width(): '+navibrand.width()+'<br/>');
            offset = navibrand.parent().offset();
            //$('#console').append('offset.left: '+offset.left+'<br/>');
            sum = -navibrand.width()-offset.left
            //$('#console').append('sum: '+sum+'<br/>');
          }
      })
    } else {
      $(navibrand).show('', function(){
        $(navibrand).animate({
          left : 0
          },{
            easing: 'easeOutBounce',
            duration: 1200,
            complete: function(){
              animatingbrand = false;
              //$('#console').append('animatingbrand: '+animatingbrand+'<br/>');
            }
        })        
      }
    )}
  };

  var viewswitchcheck = function() {
    var windowscrolltop = $(window).scrollTop();
    var navioffset = $("#main-navigation-anchor").offset().top;
    
    if (windowscrolltop > navioffset) {
      if(status == "normal")switched = true;
      status = 'scrolled';
      //$('#console').append('switched: '+switched+'<br/>');
      //$('#console').append('status: '+status+'<br/>');
    } else {
      if(status == "scrolled")switched = true;
      status = 'normal';
      //$('#console').append('switched: '+switched+'<br/>');
      //$('#console').append('status: '+status+'<br/>');
    }
    
    if(switched && animatingbrand == false || animatingbrand == false && status == "normal" && $(navibrand).is(":visible") == true){
      togglebrand();
    }
    if(switched){
      fix();
      adjustcontent();
    }
    
    switched = false;
  };
  

  //$('#console').text('not animating');
  //if(navibrand.not(":animated")){
  //  $(window).scroll(togglebrand);
  //}

  var switched = false;
  var status = 'normal';
  var navibrand = $("#main-navigation .brand");
  var animatingbrand = false;
  var offset = navibrand.parent().offset();
  var sum  = -navibrand.width()-offset.left;
  //$(navibrand).show();
  
  //$('#console').append('switched: '+switched+'<br/>');
  //$('#console').append('status: '+status+'<br/>');
  
  viewswitchcheck();
  fix();
  adjustcontent();
  togglebrand();
  $(window).scroll(viewswitchcheck)
}
$(function() {
  naviAdjust();
});
