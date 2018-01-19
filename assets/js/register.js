//jquery
$(document).ready(function() {
  // on click signup, hide login, show registration form
  $("#signup").click(function() {
    $("#first").slideUp("show", function() {
      $("#second").slideDown("slow");
    });
  });

  // on click signup, hide registration, show login form
  $("#signin").click(function() {
    $("#second").slideUp("show", function() {
      $("#first").slideDown("slow");
    });
  });
});
