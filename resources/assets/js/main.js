$(document).ready(function() {
  $('.select2').select2(); // Apply select2
  $( "#datepicker" ).datepicker();
});

function ConfirmDelete() {
  var x = confirm("Are you sure you want to delete?");
  if (x)
    return true;
  else
    return false;
}