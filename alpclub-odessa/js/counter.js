jQuery(document).ready(function($) {
	  'use strict';
$(".mc-count").each(function() {
  $(this)
    .prop("Counter", 0)
    .animate(
      {
        Counter: $(this).text()
      },
      {
        duration: 8000,
        easing: "swing",
        step: function(now) {
          $(this).text(Math.ceil(now));
        }
      }
    );
});
 
});