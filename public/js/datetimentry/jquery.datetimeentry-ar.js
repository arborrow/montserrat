/* http://keith-wood.name/dateEntry.html
   Arabic (عربي) initialisation for the jQuery date/time entry extension
   Written by Mohammad A.Baydoun (mab@modbay.me) */
(function($) {
    $.datetimeEntry.regionalOptions['ar'] = {datetimeFormat: 'D/O/Y H:Ma',
        monthNames: ['كانون الثاني', 'شباط', 'آذار', 'نيسان', 'أيار', 'حزيران',
		'تموز', 'آب', 'أيلول', 'تشرين الأول', 'تشرين الثاني', 'كانون الأول'],
        monthNamesShort: ['(ك2)', 'شباط', 'آذار', 'نيسان', 'آذار', 'حزيران',
		'تموز', 'آب', 'أيلول', '(ت1)', '(ت2)', '(ك1)'],
        dayNames: ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
        dayNamesShort: ['أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'],
        ampmNames: ['ص', 'م'],
        spinnerTexts: ['اليوم', 'الحقل السابق', 'الحقل التالي', 'زيادة', 'تنقيص'],
        isRTL: true};
    $.datetimeEntry.setDefaults($.datetimeEntry.regionalOptions['ar']);
})(jQuery);
