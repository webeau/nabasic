// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.




function firstlast() {
  $("ul > li:first-of-type").addClass("first");
  $("ul > li:last-of-type").addClass("last");
  $("ol > li:first-of-type").addClass("first");
  $("ol > li:last-of-type").addClass("last");
  $("section > article:last-of-type").addClass("last");
  $("section > article:first-of-type").addClass("first");
  $("section > section:last-of-type").addClass("last");
  $("section > section:first-of-type").addClass("first");
};

function comment_permalink_toggle() {
  $("a.permalink-link").click(function(){
    $(this).next().toggle();
  })
};
function comment_form_submit_add_class() { 
  $('input#submit').addClass('btn btn-primary');
};

function scrollto_defaults() {
  $(window).scroll(function (){
    if( $(window).scrollTop() > 400 ){
      $('#scrollTo-Top').show();
    } else {
      $('#scrollTo-Top').hide();
    }
  });
  $('#scrollTo-Top').click(function(){
    $.scrollTo('header#masthead',2000, {easing:'easeOutElastic'});
  })
  $('#scrollTo-Content').click(function(){
    $.scrollTo('#main',2000, {easing:'easeOutElastic'});
  })
  $('body.single-attachment').scrollTo('#main');
};

function wpml_topnavsubmenu_toggle() {
  if ($('.navbar ul.top-menu > li.menu-item-language > ul')){
    $('.navbar ul.top-menu > li.menu-item-language > a').append(' <span class="caret"></span>');
    //$('.navbar ul.top-menu > li.menu-item-language > a').prepend('<i class="icon-globe"></i> ');
    $('.navbar ul.top-menu > li.menu-item-language > a').click(function(){
      $(this).next().toggle();
    })
  }
};

function smooth_anker_scroll() {
  $('a[href^="#"]').bind('click.smoothscroll',function (e) {
      e.preventDefault();
      var target = this.hash;
          $target = $(target);
      $('html, body').stop().animate({
          'scrollTop': $target.offset().top
      }, 500, 'swing', function () {
          window.location.hash = target;
      });
  });
};








