jQuery(document).ready(function(){ 
    jQuery("#mobile-nav div.menu").hide(); 
    jQuery('#mobile-nav').click(function(){
    jQuery("#mobile-nav div.menu").slideToggle();
    }); 
});

jQuery(function(){
    var content_height = jQuery('#content').height();
    var sidebar_height = jQuery('#sidebar').height();
    if (content_height < sidebar_height) {
       jQuery('#content').css('border-right', 'none');
       jQuery('#sidebar').css('border-left', '1px solid #eaeaea');
    }
}); 



jQuery(function() {
jQuery('table tr.sticky div.topic-title a.forum-post-title').before('<span class="sticky-label"></span>');
jQuery('table tr.status-closed div.topic-title a.forum-post-title').before('<span class="closed-label"></span>');
});




jQuery(function(){
    var $container = jQuery('ul.masonry-posts');

    $container.masonry({
    itemSelector: 'li.blog-thumbs-view-entry'
    });

    $container.imagesLoaded().progress( function() {
      $container.masonry();
    });
});


/**
 * Protect window.console method calls, e.g. console is not defined on IE
 * unless dev tools are open, and IE doesn't define console.debug
 */
(function() {
  if (!window.console) {
    window.console = {};
  }
  // union of Chrome, FF, IE, and Safari console methods
  var m = [
    "log", "info", "warn", "error", "debug", "trace", "dir", "group",
    "groupCollapsed", "groupEnd", "time", "timeEnd", "profile", "profileEnd",
    "dirxml", "assert", "count", "markTimeline", "timeStamp", "clear"
  ];
  // define undefined methods as noops to prevent errors
  for (var i = 0; i < m.length; i++) {
    if (!window.console[m[i]]) {
      window.console[m[i]] = function() {};
    }    
  } 
})();


jQuery(function(){
jQuery('.wp-caption').removeAttr( 'style' );
jQuery('.wp-caption img').removeAttr( 'width' ).removeAttr( 'height' );
});

jQuery(document).ready(function() {
    jQuery( "body" ).fadeIn("slow");
});
