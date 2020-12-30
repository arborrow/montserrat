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
  var timeOptions = {
    enableTime: true,
    allowInput: true,
    noCalendar: true,
    altInput: true,
    dateFormat: "H:i",
    time_24hr: true
  }

  $('.select2').select2(); // Apply select2
  $('.flatpickr-date').flatpickr(dateOptions); // Apply flatpickr
  $('.flatpickr-date-time').flatpickr(dateTimeOptions);
  $('.flatpickr-time').flatpickr(timeOptions);
});
