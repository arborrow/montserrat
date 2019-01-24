import flatpickr from "flatpickr";

$(document).ready(function() {
  var dateOptions = {
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d"
  }

  var dateTimeOptions = {
    enableTime: true,
    altInput: true,
    altFormat: "F j, Y h:i K",
    dateFormat: "Y-m-d H:i"
  }

  $('.select2').select2(); // Apply select2
  $('.flatpickr-date').flatpickr(dateOptions); // Apply flatpickr
  $('.flatpickr-date-time').flatpickr(dateTimeOptions);
});