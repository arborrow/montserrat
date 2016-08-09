/* http://keith-wood.name/datetimeEntry.html
   Date and time entry for jQuery v2.0.0.
   Written by Keith Wood (kbwood{at}iinet.com.au) September 2010.
   Licensed under the MIT (https://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt) license.
   Please attribute the author if you use it. */

(function($) { // Hide scope, no $ conflict

	var pluginName = 'datetimeEntry';

	/** Create the date/time entry plugin.
		<p>Sets an input field to add a spinner for date/time entry.</p>
		<p>The date/time can be entered via directly typing the value,
		via the arrow keys, or via spinner buttons.
		It is configurable to just date or time, to format the input,
		to enforce a minimum and/or maximum date/time, to change the spinner image,
		and to constrain the time to steps, e.g. only on the quarter hours.</p>
		<p>Expects HTML like:</p>
		<pre>&lt;input type="text"></pre>
		<p>Provide inline configuration like:</p>
		<pre>&lt;input type="text" data-datetimeEntry="name: 'value'"></pre>
	 	@module DateTimeEntry
		@augments JQPlugin
		@example $(selector).datetimeEntry()
 $(selector).datetimeEntry({showSeconds: true, minTime: new Date(0, 0, 0, 12, 0, 0)}) */
	$.JQPlugin.createPlugin({
	
		/** The name of the plugin. */
		name: pluginName,
			
		/** Date/time entry before show callback.
			Triggered when the input field is focussed.
			@callback beforeShowCallback
			@param input {Element} The current input field.
			@return {object} Any changes to the instance settings.
			@example beforeShow: function(input) {
	// Cross-populate minimum/maximum times for a range
 	return {minDatetime: (input.id === 'timeTo' ?
 		$('#timeFrom').datetimeEntry('getDatetime') : null), 
 		maxDatetime: (input.id === 'timeFrom' ?
 		$('#timeTo').datetimeEntry('getDatetime') : null)};
 } */
			
		/** Default settings for the plugin.
			@property [appendText=''] {string} Display text following the input box, e.g. showing the format.
			@property [initialField=null] {number} The field to highlight initially, or <code>null</code> for none.
			@property [tabToExit=false] {boolean} True for tab key to go to next element,
						false for tab key to step through internal fields.
			@property [useMouseWheel=true] {boolean} True to use mouse wheel for increment/decrement if possible,
						false to never use it.
			@property [shortYearCutoff='+10'] {string|number} The century cutoff for two-digit years,
						absolute (numeric) or relative (+/- value).
			@property [defaultDatetime=null] {Date|number|string} The date/time to use if none has been set,
						leave at <code>null</code> for now. Specify as a <code>Date</code> object, as a number of seconds
						offset from now, or as a string of offsets from now, using 'Y' for years, 'O' for months,
						'W' for weeks, 'D' for days, 'H' for hours, 'M' for minutes, 'S' for seconds.
			@property [minDatetime=null] {Date|number|string} The earliest selectable date/time,
						or <code>null</code> for no limit. See <code>defaultDatetime</code> for possible formats.
			@property [maxDatetime=null] {Date|number|string} The latest selectable date/time,
						or <code>null</code> for no limit. See <code>defaultDatetime</code> for possible formats.
			@property [minTime=null] {Date|number|string} The earliest selectable time regardless of date,
						or <code>null</code> for no limit. See <code>defaultDatetime</code> for possible formats.
			@property [maxTime=null] {Date|number|string} The latest selectable time regardless of date,
						or <code>null</code> for no limit. See <code>defaultDatetime</code> for possible formats.
			@property [timeSteps=[1,1,1]] {number[]} Steps for each of hours/minutes/seconds when incrementing/decrementing.
			@property [spinnerImage='spinnerDefault.png'] {string} The URL of the images to use for the date spinner -
						seven images packed horizontally for normal, each button pressed
						(centre, previous, next, increment, decrement), and disabled.
			@property [spinnerSize=[20,20,8]] {number[]} The width and height of the spinner image,
						and size of centre button for current date.
			@property [spinnerBigImage=''] {string} The URL of the images to use for the expanded date spinner -
						seven images packed horizontally for normal, each button pressed
						(centre, previous, next, increment, decrement), and disabled.
			@property [spinnerBigSize=[40,40,16]] {number[]} The width and height of the expanded spinner image,
						and size of centre button for current date.
			@property [spinnerIncDecOnly=false] {boolean} True for increment/decrement buttons only, false for all.
			@property [spinnerRepeat=[500,250]] {number[]} Initial and subsequent waits in milliseconds
						for repeats on the spinner buttons.
			@property [beforeShow=null] {beforeShowCallback} Function that takes an input field and
						returns a set of custom settings for the date entry.
			@property [altField=null] {string|Element|jQuery} Selector, element, or jQuery object
						for an alternate field to keep synchronised.
			@property [altFormat=null] {string} A separate format for the alternate field.
						See <code>datetimeFormat</code> for options.
			@example {defaultDatetime: new Date(2013, 12-1, 25, 8, 30, 0), minTime: -300, maxTime: '+2H +30M'} */
		defaultOptions: {
			appendText: '',
			initialField: null,
			tabToExit: false,
			useMouseWheel: true,
			shortYearCutoff: '+10',
			defaultDatetime: null,
			minDatetime: null,
			maxDatetime: null,
			minTime: null,
			maxTime: null,
			timeSteps: [1, 1, 1],
			spinnerImage: 'spinnerDefault.png',
			spinnerSize: [20, 20, 8],
			spinnerBigImage: '',
			spinnerBigSize: [40, 40, 16],
			spinnerIncDecOnly: false,
			spinnerRepeat: [500, 250],
			beforeShow: null,
			altField: null,
			altFormat: null
		},

		/** Localisations for the plugin.
			Entries are objects indexed by the language code ('' being the default US/English).
			Each object has the following attributes.
			@property [datetimeFormat='O/D/Y H:Ma'] {string} The format of the date text:
						'y' for short year, 'Y' for full year, 'o' for month, 'O' for two-digit month,
						'n' for abbreviated month name, 'N' for full month name,
						'd' for day, 'D' for two-digit day, 'w' for abbreviated day name and number,
						'W' for full day name and number), 'h' for hour, 'H' for two-digit hour,
						'm' for minute, 'M' for two-digit minutes, 's' for seconds,
						'S' for two-digit seconds, 'a' for AM/PM indicator (omit for 24-hour).
			@property [datetimeSeparators='.'] {string} Additional separators between date/time portions.
			@property [monthNames=['January','February','March','April','May','June','July','August','September','October','November','December']]
						{string[]} The names of the months.
			@property [monthNamesShort=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']]
						{string[]} The abbreviated names of the months.
			@property [dayNames=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']]
						{string[]} The names of the days.
			@property [dayNamesShort=['Sun','Mon','Tue','Wed','Thu','Fri','Sat']]
						{string[]} The abbreviated names of the days.
			@property [ampmNames=['AM','PM']] {string[]} The names of morning/evening markers.
			@property [spinnerTexts=['Today','Previous&nbsp;field','Next&nbsp;field','Increment','Decrement']]
						{string[]} The popup texts for the spinner image areas.
			@property [isRTL=false] {boolean} Does this language run right-to-left? */
		regionalOptions: { // Available regional settings, indexed by language/country code
			'': { // Default regional settings - English/US
				datetimeFormat: 'O/D/Y H:Ma',
				datetimeSeparators: '.',
				monthNames: ['January', 'February', 'March', 'April', 'May', 'June',
					'July', 'August', 'September', 'October', 'November', 'December'],
				monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
				dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
				ampmNames: ['AM', 'PM'],
				spinnerTexts: ['Today', 'Previous field', 'Next field', 'Increment', 'Decrement'],
				isRTL: false
			}
		},
		
		_getters: ['getDatetime', 'getOffset', 'isDisabled'],

		_appendClass: pluginName + '-append', // Class name for the appended content
		_controlClass: pluginName + '-control', // Class name for the date/time entry control
		_expandClass: pluginName + '-expand', // Class name for the expanded spinner

		_disabledInputs: [], // List of date/time inputs that have been disabled

		_instSettings: function(elem, options) {
			return {_field: 0, _selectedYear: 0, _selectedMonth: 0, _selectedDay: 0,
				_selectedHour: 0, _selectedMinute: 0, _selectedSecond: 0};
		},
		
		_postAttach: function(elem, inst) {
			this._decodeDatetimeFormat(inst);
			elem.on('focus.' + inst.name, this._doFocus).
				on('blur.' + inst.name, this._doBlur).
				on('click.' + inst.name, this._doClick).
				on('keydown.' + inst.name, this._doKeyDown).
				on('keypress.' + inst.name, this._doKeyPress).
				on('paste.' + inst.name, function(event) { // Check pastes
					setTimeout(function() { plugin._extractDatetime(inst); }, 1);
				});
		},

		_optionsChanged: function(elem, inst, options) {
			var currentDatetime = this._parseDatetime(inst, elem.val());
			$.extend(inst.options, options);
			inst._field = 0;
			this._decodeDatetimeFormat(inst);
			if (currentDatetime) {
				this._setDatetime(inst, currentDatetime);
			}
			// Remove stuff dependent on old settings
			elem.next('span.' + this._appendClass).remove();
			elem.parent().find('span.' + this._controlClass).remove();
			if ($.fn.mousewheel) {
				elem.unmousewheel();
			}
			// And re-add if requested
			var spinner = (!inst.options.spinnerImage ? null :
				$('<span class="' + this._controlClass + '" style="display: inline-block; ' +
				'background: url(\'' + inst.options.spinnerImage + '\') 0 0 no-repeat; width: ' + 
				inst.options.spinnerSize[0] + 'px; height: ' + inst.options.spinnerSize[1] + 'px;"></span>'));
			elem.after(inst.options.appendText ? '<span class="' + this._appendClass + '">' +
				inst.options.appendText + '</span>' : '').after(spinner || '');
			// Allow mouse wheel usage
			if (inst.options.useMouseWheel && $.fn.mousewheel) {
				elem.mousewheel(this._doMouseWheel);
			}
			if (spinner) {
				spinner.mousedown(this._handleSpinner).mouseup(this._endSpinner).
					mouseover(this._expandSpinner).mouseout(this._endSpinner).
					mousemove(this._describeSpinner);
			}
		},

		/** Enable a date/time entry input and any associated spinner.
			@param elem {Element} The single input field.
			@example $(selector).datetimeEntry('enable') */
		enable: function(elem) {
			this._enableDisable(elem, false);
		},

		/** Disable a date/time entry input and any associated spinner.
			@param elem {Element} The single input field.
			@example $(selector).datetimeEntry('disable') */
		disable: function(elem) {
			this._enableDisable(elem, true);
		},

		/** Enable or disable a date/time entry input and any associated spinner.
			@private
			@param elem {Element} The single input field.
			@param disable {boolean} True to disable, false to enable. */
		_enableDisable: function(elem, disable) {
			var inst = this._getInst(elem);
			if (!inst) {
				return;
			}
			elem.disabled = disable;
			if (elem.nextSibling && elem.nextSibling.nodeName.toLowerCase() === 'span') {
				this._changeSpinner(inst, elem.nextSibling, (disable ? 5 : -1));
			}
			this._disabledInputs = $.map(this._disabledInputs,
				function(value) { return (value === elem ? null : value); }); // Delete entry
			if (disable) {
				this._disabledInputs.push(elem);
			}
		},

		/** Check whether an input field has been disabled.
			@param elem {Element} The input field to check.
			@return {boolean} True if this field has been disabled, false if it is enabled.
			@example if ($(selector).datetimeEntry('isDisabled')) {...} */
		isDisabled: function(elem) {
			return $.inArray(elem, this._disabledInputs) > -1;
		},

		_preDestroy: function(elem, inst) {
			elem = $(elem).off('.' + pluginName);
			if ($.fn.mousewheel) {
				elem.unmousewheel();
			}
			this._disabledInputs = $.map(this._disabledInputs,
				function(value) { return (value === elem[0] ? null : value); }); // Delete entry
			elem.siblings('.' + this._appendClass + ',.' + this._controlClass).remove();
		},

		/** Locate fields within the date/time format.
			@private
			@param inst {object} The instance settings. */
		_decodeDatetimeFormat: function(inst) {
			inst._fields = [];
			inst._ampmField = -1;
			for (var i = 0; i < inst.options.datetimeFormat.length; i++) {
				if (inst.options.datetimeFormat.charAt(i).match(/[yYoOnNdDwWhHmMsSa]/)) {
					inst._fields.push(i);
				}
				if (inst.options.datetimeFormat.charAt(i) === 'a') {
					inst._ampmField = inst._fields.length - 1;
				}
			}
		},

		/** Initialise the current date/time for a date/time entry input field.
			@param elem {Element} The input field to update.
			@param datetime {Date|number|string} The new date/time or offset or <code>null</code> to clear.
					An actual date or offset in seconds from now or units and periods of offsets from now.
			@example $(selector).datetimeEntry('setDatetime', new Date(2013, 12-1, 25, 11, 22, 33))
 $(selector).datetimeEntry('setDatetime', +300)
 $(selector).datetimeEntry('setDatetime', '+1W +12H')
 $(selector).datetimeEntry('setDatetime', null) */
		setDatetime: function(elem, datetime) {
			var inst = this._getInst(elem);
			if (inst) {
				if (datetime === null || datetime === '') {
					$(elem).val('');
				}
				else {
					this._setDatetime(inst, datetime ? (typeof datetime === 'object' ?
						new Date(datetime.getTime()) : datetime) : null);
				}
			}
		},

		/** Retrieve the current date/time for a date/time entry input field.
			@param elem {Element} The input field to update.
			@return {Date} The current date/time or <code>null</code> if none.
			@example var time = $(selector).datetimeEntry('getDatetime') */
		getDatetime: function(elem) {
			var inst = this._getInst(elem);
			return (inst ? this._parseDatetime(inst, inst.elem.val()) : null);
		},

		/** Retrieve the millisecond offset for the current time.
			@param elem {Element} The input field to examine.
			@return {number} The time as milliseconds offset or zero if none.
			@example var offset = $(selector).datetimeEntry('getOffset')  */
		getOffset: function(elem) {
			var inst = this._getInst(elem);
			var time = (inst ? this._parseDatetime(inst, inst.elem.val()) : null);
			return (!time ? 0 :
				(time.getHours() * 3600 + time.getMinutes() * 60 + time.getSeconds()) * 1000);
		},

		/** Initialise date/time entry.
			@private
			@param elem {Element|Event} The input field or the focus event. */
		_doFocus: function(elem) {
			var input = (elem.nodeName && elem.nodeName.toLowerCase() === 'input' ? elem : this);
			if (plugin._lastInput === input || plugin.isDisabled(input)) {
				return;
			}
			var inst = plugin._getInst(input);
			inst._field = 0;
			plugin._lastInput = input;
			plugin._blurredInput = null;
			$.extend(inst.options, ($.isFunction(inst.options.beforeShow) ?
				inst.options.beforeShow.apply(input, [input]) : {}));
			plugin._extractDatetime(inst, elem.nodeName ? null : elem);
			setTimeout(function() { plugin._showField(inst); }, 10);
		},

		/** Note that the field has been exited.
			@private
			@param event {Event} The blur event. */
		_doBlur: function(event) {
			plugin._blurredInput = plugin._lastInput;
			plugin._lastInput = null;
		},

		/** Select appropriate field portion on click, if already in the field.
			@private
			@param event {Event} The click event. */
		_doClick: function(event) {
			var input = event.target;
			var inst = plugin._getInst(input);
			var prevField = inst._field;
			inst._field = plugin._getSelection(inst, input, event);
			if (prevField !== inst._field) {
				inst._lastChr = '';
			}
			plugin._showField(inst);
		},

		/** Find the selected subfield within the control.
			@private
			@param inst {object} The current instance settings.
			@param input {Element} The input control.
			@param event {Event} The triggering event.
			@return {number} The selected subfield. */
		_getSelection: function(inst, input, event) {
			var select = 0;
			var datetimeFormat = inst.options.datetimeFormat;
			if (typeof input.selectionStart !== 'undefined') { // Use input select range
				var end = 0;
				for (var field = 0; field < datetimeFormat.length; field++) {
					end += plugin._fieldLength(inst, datetimeFormat.charAt(field));
					if (input.selectionStart < end) {
						break;
					}
					select += (datetimeFormat.charAt(field).match(/[yondwhmsa]/i) ? 1 : 0);
				}
			}
			else if (input.createTextRange && event != null && $(input).val()) { // Check against bounding boxes
				var src = $(event.target || event.srcElement);
				var range = input.createTextRange();
				var convert = function(value) {
					return {thin: 2, medium: 4, thick: 6}[value] || value;
				};
				var offsetX = (event.clientX || 0) + document.documentElement.scrollLeft -
					(src.offset().left + parseInt(convert(src.css('border-left-width')), 10)) -
					range.offsetLeft; // Position - left edge - alignment
				var end = 0;
				for (var field = 0; field < datetimeFormat.length; field++) {
					end += plugin._fieldLength(inst, datetimeFormat.charAt(field));
					range.collapse();
					range.moveEnd('character', end);
					if (offsetX < range.boundingWidth) { // And compare
						break;
					}
					select += (datetimeFormat.charAt(field).match(/[yondwhmsa]/i) ? 1 : 0);
				}
			}
			return select;
		},

		/** Handle keystrokes in the field.
			@private
			@param event {Event} The keydown event.
			@return {boolean} True to continue, false to stop processing. */
		_doKeyDown: function(event) {
			if (event.keyCode >= 48) { // >= '0'
				return true;
			}
			var inst = plugin._getInst(event.target);
			switch (event.keyCode) {
				case 9: return (inst.options.tabToExit ? true : (event.shiftKey ?
							// Move to previous date/time field, or out if at the beginning
							plugin._changeField(inst, -1, true) :
							// Move to next date/time field, or out if at the end
							plugin._changeField(inst, +1, true)));
				case 35: if (event.ctrlKey) { // Clear date/time on ctrl+end
							plugin._setValue(inst, '');
						}
						else { // Last field on end
							inst._field = inst._fields.length - 1;
							plugin._adjustField(inst, 0);
						}
						break;
				case 36: if (event.ctrlKey) { // Current date/time on ctrl+home
							plugin._setDatetime(inst);
						}
						else { // First field on home
							inst._field = 0;
							plugin._adjustField(inst, 0);
						}
						break;
				case 37: plugin._changeField(inst, -1, false); break; // Previous field on left
				case 38: plugin._adjustField(inst, +1); break; // Increment date/time field on up
				case 39: plugin._changeField(inst, +1, false); break; // Next field on right
				case 40: plugin._adjustField(inst, -1); break; // Decrement date/time field on down
				case 46: plugin._setValue(inst, ''); break; // Clear date/time on delete
				default: return true;
			}
			return false;
		},

		/** Disallow unwanted characters.
			@private
			@param event {Event} The keypress event.
			@return {boolean} True to continue, false to stop processing. */
		_doKeyPress: function(event) {
			var chr = String.fromCharCode(event.charCode === undefined ? event.keyCode : event.charCode);
			if (chr < ' ') {
				return true;
			}
			var inst = plugin._getInst(event.target);
			plugin._handleKeyPress(inst, chr);
			return false;
		},

		/* Update date/time based on keystroke entered.
		   @param inst {object} The instance settings.
		   @param chr {string} The new character. */
		_handleKeyPress: function(inst, chr) {
			chr = chr.toLowerCase();
			var field = inst.options.datetimeFormat.charAt(inst._fields[inst._field]);
			var sep = inst.options.datetimeFormat.charAt(inst._fields[inst._field] + 1);
			sep = ('yYoOnNdDwWhHmMsSa'.indexOf(sep) === -1 ? sep : '');
			if ((inst.options.datetimeSeparators + sep).indexOf(chr) > -1) {
				this._changeField(inst, +1, false);
			}
			else if (chr >= '0' && chr <= '9') { // Allow direct entry of date/time
				var key = parseInt(chr, 10);
				var value = parseInt(inst._lastChr + chr, 10);
				var year = (!field.match(/y/i) ? inst._selectedYear : value);
				var month = (!field.match(/o|n/i) ? inst._selectedMonth + 1 :
					(value >= 1 && value <= 12 ? value : (key > 0 ? key : inst._selectedMonth + 1)));
				var day = (!field.match(/d|w/i) ? inst._selectedDay :
					(value >= 1 && value <= this._getDaysInMonth(year, month - 1) ?
					value : (key > 0 ? key : inst._selectedDay)));
				var hour = (!field.match(/h/i) ? inst._selectedHour : (inst._ampmField === -1 ?
					(value < 24 ? value : key) : (value >= 1 && value <= 12 ? value :
					(key > 0 ? key : inst._selectedHour)) % 12 + (inst._selectedHour >= 12 ? 12 : 0)));
				var minute = (!field.match(/m/i) ? inst._selectedMinute : (value < 60 ? value : key));
				var second = (!field.match(/s/i) ? inst._selectedSecond : (value < 60 ? value : key));
				var fields = this._constrainTime(inst, [hour, minute, second]);
				var shortYearCutoff = this._shortYearCutoff(inst);
				this._setDatetime(inst, new Date(
					year + (year >= 100 || field !== 'y' ? 0 : (year > shortYearCutoff ? 1900 : 2000)),
					month - 1, day, fields[0], fields[1], fields[2]));
				inst._lastChr = (field !== 'Y' ? '' :
					inst._lastChr.substr(Math.max(0, inst._lastChr.length - 2))) + chr;
			}
			else if (field.match(/n/i)) { // Allow text entry by month name
				inst._lastChr += chr;
				var names = inst.options[field === 'n' ? 'monthNamesShort' : 'monthNames'];
				var findMonth = function() {
					for (var i = 0; i < names.length; i++) {
						if (names[i].toLowerCase().substring(0, inst._lastChr.length) === inst._lastChr) {
							return i;
							break;
						}
					}
					return -1;
				};
				var month = findMonth();
				if (month === -1) {
					inst._lastChr = chr.toLowerCase();
					month = findMonth();
				}
				if (month === -1) {
					inst._lastChr = '';
				}
				else {
					var year = inst._selectedYear;
					var day = Math.min(inst._selectedDay, this._getDaysInMonth(year, month));
					this._setDatetime(inst, this._normaliseDatetime(new Date(year, month, day,
						inst._selectedHour, inst._selectedMinute, inst._selectedSecond)));
				}
			}
			else if (inst._ampmField > -1) { // Set am/pm based on first char of names
				if ((chr === inst.options.ampmNames[0].substring(0, 1).toLowerCase() &&
						inst._selectedHour >= 12) ||
						(chr === inst.options.ampmNames[1].substring(0, 1).toLowerCase() &&
						inst._selectedHour < 12)) {
					var saveField = inst._field;
					inst._field = inst._ampmField;
					this._adjustField(inst, +1);
					inst._field = saveField;
					this._showField(inst);
				}
			}
		},

		/** Increment/decrement on mouse wheel activity.
			@private
			@param event {Event} The mouse wheel event.
			@param delta {number} The amount of change. */
		_doMouseWheel: function(event, delta) {
			if (plugin.isDisabled(event.target)) {
				return;
			}
			var inst = plugin._getInst(event.target);
			inst.elem.focus();
			if (!inst.elem.val()) {
				plugin._extractDatetime(inst);
			}
			plugin._adjustField(inst, delta);
			event.preventDefault();
		},

		/** Expand the spinner, if possible, to make it easier to use.
			@private
			@param event {Event} The mouse over event. */
		_expandSpinner: function(event) {
			var spinner = plugin._getSpinnerTarget(event);
			var inst = plugin._getInst(plugin._getInput(spinner));
			if (plugin.isDisabled(inst.elem[0])) {
				return;
			}
			if (inst.options.spinnerBigImage) {
				inst._expanded = true;
				var offset = $(spinner).offset();
				var relative = null;
				$(spinner).parents().each(function() {
					var parent = $(this);
					if (parent.css('position') === 'relative' || parent.css('position') === 'absolute') {
						relative = parent.offset();
					}
					return !relative;
				});
				$('<div class="' + plugin._expandClass + '" style="position: absolute; left: ' +
					(offset.left - (inst.options.spinnerBigSize[0] - inst.options.spinnerSize[0]) / 2 -
					(relative ? relative.left : 0)) + 'px; top: ' +
					(offset.top - (inst.options.spinnerBigSize[1] - inst.options.spinnerSize[1]) / 2 -
					(relative ? relative.top : 0)) + 'px; width: ' +
					inst.options.spinnerBigSize[0] + 'px; height: ' +
					inst.options.spinnerBigSize[1] + 'px; background: transparent url(' +
					inst.options.spinnerBigImage + ') no-repeat 0px 0px; z-index: 10;"></div>').
					mousedown(plugin._handleSpinner).mouseup(plugin._endSpinner).
					mouseout(plugin._endExpand).mousemove(plugin._describeSpinner).
					insertAfter(spinner);
			}
		},

		/** Locate the actual input field from the spinner.
			@private
			@param spinner {Element} The current spinner.
			@return {Element} The corresponding input. */
		_getInput: function(spinner) {
			return $(spinner).siblings('.' + this._getMarker())[0];
		},

		/** Change the title based on position within the spinner.
			@private
			@param event {Event} The mouse move event. */
		_describeSpinner: function(event) {
			var spinner = plugin._getSpinnerTarget(event);
			var inst = plugin._getInst(plugin._getInput(spinner));
			spinner.title = inst.options.spinnerTexts[plugin._getSpinnerRegion(inst, event)];
		},

		/** Handle a click on the spinner.
			@private
			@param event {Event} The mouse click event. */
		_handleSpinner: function(event) {
			var spinner = plugin._getSpinnerTarget(event);
			var input = plugin._getInput(spinner);
			if (plugin.isDisabled(input)) {
				return;
			}
			if (input === plugin._blurredInput) {
				plugin._lastInput = input;
				plugin._blurredInput = null;
			}
			var inst = plugin._getInst(input);
			plugin._doFocus(input);
			var region = plugin._getSpinnerRegion(inst, event);
			plugin._changeSpinner(inst, spinner, region);
			plugin._actionSpinner(inst, region);
			plugin._timer = null;
			plugin._handlingSpinner = true;
			if (region >= 3 && inst.options.spinnerRepeat[0]) { // Repeat increment/decrement
				plugin._timer = setTimeout(
					function() { plugin._repeatSpinner(inst, region); },
					inst.options.spinnerRepeat[0]);
				$(spinner).one('mouseout', plugin._releaseSpinner).
					one('mouseup', plugin._releaseSpinner);
			}
		},

		/** Action a click on the spinner.
			@private
			@param inst {object} The instance settings.
			@param region {number} The spinner "button". */
		_actionSpinner: function(inst, region) {
			if (!inst.elem.val()) {
				plugin._extractDatetime(inst);
			}
			switch (region) {
				case 0: this._setDatetime(inst); break;
				case 1: this._changeField(inst, -1, false); break;
				case 2: this._changeField(inst, +1, false); break;
				case 3: this._adjustField(inst, +1); break;
				case 4: this._adjustField(inst, -1); break;
			}
		},

		/** Repeat a click on the spinner.
			@private
			@param inst {object} The instance settings.
			@param region {number} The spinner "button". */
		_repeatSpinner: function(inst, region) {
			if (!plugin._timer) {
				return;
			}
			plugin._lastInput = plugin._blurredInput;
			this._actionSpinner(inst, region);
			this._timer = setTimeout(
				function() { plugin._repeatSpinner(inst, region); },
				inst.options.spinnerRepeat[1]);
		},

		/** Stop a spinner repeat.
			@private
			@param event {Event} The mouse event. */
		_releaseSpinner: function(event) {
			clearTimeout(plugin._timer);
			plugin._timer = null;
		},

		/** Tidy up after an expanded spinner.
			@private
			@param event {Event} The mouse event. */
		_endExpand: function(event) {
			plugin._timer = null;
			var spinner = plugin._getSpinnerTarget(event);
			var input = plugin._getInput(spinner);
			var inst = plugin._getInst(input);
			$(spinner).remove();
			inst._expanded = false;
		},

		/** Tidy up after a spinner click.
			@private
			@param event {Event} The mouse event. */
		_endSpinner: function(event) {
			plugin._timer = null;
			var spinner = plugin._getSpinnerTarget(event);
			var input = plugin._getInput(spinner);
			var inst = plugin._getInst(input);
			if (!plugin.isDisabled(input)) {
				plugin._changeSpinner(inst, spinner, -1);
			}
			if (plugin._handlingSpinner) {
				plugin._lastInput = plugin._blurredInput;
			}
			if (plugin._lastInput && plugin._handlingSpinner) {
				plugin._showField(inst);
			}
			plugin._handlingSpinner = false;
		},

		/** Retrieve the spinner from the event.
			@private
			@param event {Event} The mouse click event.
			@return {Element} The target field. */
		_getSpinnerTarget: function(event) {
			return event.target || event.srcElement;
		},

		/** Determine which "button" within the spinner was clicked.
			@private
			@param inst {object} The instance settings.
			@param event {Event} The mouse event.
			@return {number} The spinner "button" number. */
		_getSpinnerRegion: function(inst, event) {
			var spinner = this._getSpinnerTarget(event);
			var pos = $(spinner).offset();
			var scrolled = [document.documentElement.scrollLeft || document.body.scrollLeft,
				document.documentElement.scrollTop || document.body.scrollTop];
			var left = (inst.options.spinnerIncDecOnly ? 99 : event.clientX + scrolled[0] - pos.left);
			var top = event.clientY + scrolled[1] - pos.top;
			var spinnerSize = inst.options[inst._expanded ? 'spinnerBigSize' : 'spinnerSize'];
			var right = (inst.options.spinnerIncDecOnly ? 99 : spinnerSize[0] - 1 - left);
			var bottom = spinnerSize[1] - 1 - top;
			if (spinnerSize[2] > 0 && Math.abs(left - right) <= spinnerSize[2] &&
					Math.abs(top - bottom) <= spinnerSize[2]) {
				return 0; // Centre button
			}
			var min = Math.min(left, top, right, bottom);
			return (min === left ? 1 : (min === right ? 2 : (min === top ? 3 : 4))); // Nearest edge
		},

		/** Change the spinner image depending on the button clicked.
			@private
			@param inst {object} The instance settings.
			@param spinner {Element} The spinner control.
			@param region {number} The spinner "button". */
		_changeSpinner: function(inst, spinner, region) {
			$(spinner).css('background-position', '-' + ((region + 1) *
				inst.options[inst._expanded ? 'spinnerBigSize' : 'spinnerSize'][0]) + 'px 0px');
		},
		
		/** Extract the date/time value from the input field, or default to now.
			@private
			@param inst {object} The instance settings.
			@param event {Event} The triggering event or <code>null</code>. */
		_extractDatetime: function(inst, event) {
			var currentDatetime = this._parseDatetime(inst, inst.elem.val()) || this._normaliseDatetime(
				this._determineDatetime(inst, inst.options.defaultDatetime) || new Date());
			var fields = this._constrainTime(inst, [currentDatetime.getHours(),
				currentDatetime.getMinutes(), currentDatetime.getSeconds()]);
			inst._selectedYear = currentDatetime.getFullYear();
			inst._selectedMonth = currentDatetime.getMonth();
			inst._selectedDay = currentDatetime.getDate();
			inst._selectedHour = fields[0];
			inst._selectedMinute = fields[1];
			inst._selectedSecond = fields[2];
			inst._lastChr = '';
			var postProcess = function() {
				if (inst.elem.val() !== '') {
					plugin._showDatetime(inst);
				}
			};
			if (typeof inst.options.initialField === 'number') {
				inst._field = Math.max(0, inst.options.initialField);
				postProcess();
			}
			else {
				setTimeout(function() {
					inst._field = plugin._getSelection(inst, inst.elem[0], event);
					postProcess();
				}, 0);
			}
		},

		/** Parse the date/time value from the given text.
			@private
			@param inst {object} The instance settings.
			@param value {string} The value to parse.
			@return {Date} The retrieved date/time or <code>null</code> if no value. */
		_parseDatetime: function(inst, value) {
			if (!value) {
				return null;
			}
			var year = 0;
			var month = 0;
			var day = 0;
			var hour = 0;
			var minute = 0;
			var second = 0;
			var seen = [false, false, false];
			var index = 0;
			var datetimeFormat = inst.options.datetimeFormat;
			var skipNumber = function() {
				while (index < value.length && value.charAt(index).match(/^[0-9]/)) {
					index++;
				}
			};
			var i;
			for (i = 0; i < datetimeFormat.length && index < value.length; i++) {
				var field = datetimeFormat.charAt(i);
				var num = parseInt(value.substring(index), 10);
				if (field.match(/y|o|d|h|m|s/i) && isNaN(num)) {
					throw 'Invalid date/time';
				}
				num = (isNaN(num) ? 0 : num);
				switch (field) {
					case 'y': case 'Y':
						year = num;
						skipNumber();
						seen[0] = true; 
						break;
					case 'o': case 'O':
						month = num;
						skipNumber();
						seen[1] = true; 
						break;
					case 'n': case 'N': 
						var monthNames = inst.options[field === 'N' ? 'monthNames' : 'monthNamesShort'];
						for (var j = 0; j < monthNames.length; j++) {
							if (value.substring(index).substr(0, monthNames[j].length).toLowerCase() ===
									monthNames[j].toLowerCase()) {
								month = j + 1;
								index += monthNames[j].length;
								break;
							}
						}
						seen[1] = true; 
						break;
					case 'w': case 'W':
						var dayNames = inst.options[field === 'W' ? 'dayNames' : 'dayNamesShort'];
						for (var j = 0; j < dayNames.length; j++) {
							if (value.substring(index).substr(0, dayNames[j].length).toLowerCase() ===
									dayNames[j].toLowerCase()) {
								index += dayNames[j].length + 1;
								break;
							}
						}
						num = parseInt(value.substring(index), 10);
						num = (isNaN(num) ? 0 : num);
						// Fall through
					case 'd': case 'D':
						day = num;
						skipNumber();
						seen[2] = true; 
						break;
					case 'h': case 'H':
						hour = num;
						skipNumber();
						break;
					case 'm': case 'M':
						minute = num;
						skipNumber();
						break;
					case 's': case 'S':
						second = num;
						skipNumber();
						break;
					case 'a':
						var pm = (value.substr(index, inst.options.ampmNames[1].length).toLowerCase() ===
							inst.options.ampmNames[1].toLowerCase());
						hour = (hour === 12 ? 0 : hour) + (pm ? 12 : 0);
						index += inst.options.ampmNames[0].length;
						break;
					default:
						index++;
				}
			}
			if (i < datetimeFormat.length) {
				throw 'Invalid date/time';
			}
			year = seen[0] ? year : 2000;
			month = seen[1] ? month : 1;
			day = seen[2] ? day : 1;
			year += (year >= 100 || datetimeFormat.indexOf('y') === -1 ? 0 : // Short year
				(year > this._shortYearCutoff(inst) ? 1900 : 2000));
			var fields = this._constrainTime(inst, [hour, minute, second]);
			var date = new Date(year, Math.max(0, month - 1), day, fields[0], fields[1], fields[2]);
			if (datetimeFormat.match(/y|o|n|d|w/i) && (date.getFullYear() !== year ||
					date.getMonth() + 1 !== month || date.getDate() !== day)) {
				throw 'Invalid date/time';
			}
			return date;
		},

		/** Set the selected date/time into the input field.
			@private
			@param inst {object} The instance settings. */
		_showDatetime: function(inst) {
			this._setValue(inst, this._formatDatetime(inst, inst.options.datetimeFormat));
			this._showField(inst);
		},

		/** Format a date/time as requested.
			@private
			@param inst {object} The instance settings.
			@param format {string} The date/time format to use.
			@return {string} The formatted date/time. */
		_formatDatetime: function(inst, format) {
			var currentDatetime = '';
			var ampm = format.indexOf('a') > -1;
			for (var i = 0; i < format.length; i++) {
				var field = format.charAt(i);
				switch (field) {
					case 'y':
						currentDatetime += this._formatNumber(inst._selectedYear % 100);
						break;
					case 'Y':
						currentDatetime += this._formatNumber(inst._selectedYear, 4);
						break;
					case 'o': case 'O':
						currentDatetime += this._formatNumber(inst._selectedMonth + 1, field === 'o' ? 1 : 2);
						break;
					case 'n': case 'N':
						currentDatetime += inst.options[field === 'N' ?
							'monthNames' : 'monthNamesShort'][inst._selectedMonth];
						break;
					case 'd': case 'D':
						currentDatetime += this._formatNumber(inst._selectedDay, field === 'd' ? 1 : 2);
						break;
					case 'w': case 'W':
						currentDatetime += inst.options[field === 'W' ? 'dayNames' : 'dayNamesShort']
							[new Date(inst._selectedYear, inst._selectedMonth, inst._selectedDay).getDay()] +
							' ' + this._formatNumber(inst._selectedDay);
						break;
					case 'h': case 'H':
						currentDatetime += this._formatNumber(!ampm ? inst._selectedHour :
							inst._selectedHour % 12 || 12, field === 'h' ? 1 : 2);
						break;
					case 'm': case 'M':
						currentDatetime += this._formatNumber(inst._selectedMinute, field === 'm' ? 1 : 2);
						break;
					case 's': case 'S':
						currentDatetime += this._formatNumber(inst._selectedSecond, field === 's' ? 1 : 2);
						break;
					case 'a':
						currentDatetime += inst.options.ampmNames[inst._selectedHour < 12 ? 0 : 1];
						break;
					default:
						currentDatetime += field;
						break;
				}
			}
			return currentDatetime;
		},

		/** Highlight the current date/time field.
			@private
			@param inst {object} The instance settings. */
		_showField: function(inst) {
			var input = inst.elem[0];
			if (inst.elem.is(':hidden') || plugin._lastInput !== input) {
				return;
			}
			var start = 0;
			for (var i = 0; i < inst._fields[inst._field]; i++) {
				start += this._fieldLength(inst, inst.options.datetimeFormat.charAt(i));
			}
			var end = start + this._fieldLength(inst, inst.options.datetimeFormat.charAt(i));
			if (input.setSelectionRange) { // Mozilla
				input.setSelectionRange(start, end);
			}
			else if (input.createTextRange) { // IE
				var range = input.createTextRange();
				range.moveStart('character', start);
				range.moveEnd('character', end - inst.elem.val().length);
				range.select();
			}
			if (!input.disabled) {
				input.focus();
			}
		},

		/** Calculate the field length.
			@private
			@param inst {object} The instance settings.
			@param format {string} The format character.
			@return {number} The length of this subfield. */
		_fieldLength: function(inst, format) {
			switch (format) {
				case 'Y':
					return 4;
				case 'n': case 'N':
					return inst.options[format === 'N' ? 'monthNames' : 'monthNamesShort']
						[inst._selectedMonth].length;
				case 'w': case 'W':
					return inst.options[format === 'W' ? 'dayNames' : 'dayNamesShort']
						[new Date(inst._selectedYear, inst._selectedMonth, inst._selectedDay).
						getDay()].length + 3;
				case 'y': case 'O': case 'D': case 'H': case 'M': case 'S':
					return 2;
				case 'o':
					return ('' + (inst._selectedMonth + 1)).length;
				case 'd':
					return ('' + inst._selectedDay).length;
				case 'h':
					return ('' + (inst._ampmField === -1 ?
						inst._selectedHour : inst._selectedHour % 12 || 12)).length;
				case 'm':
					return ('' + inst._selectedMinute).length;
				case 's':
					return ('' + inst._selectedSecond).length;
				case 'a':
					return inst.options.ampmNames[0].length;
				default:
					return 1;
			}
		},

		/** Ensure displayed number is a certain length.
			@private
			@param value {number} The current value.
			@param length {number} The minimum length (optional, default 2).
			@return {string} The number with at least length digits. */
		_formatNumber: function(value, length) {
			value = '' + value;
			length = length || 2;
			while (value.length < length) {
				value = '0' + value;
			}
			return value;
		},

		/** Update the input field and notify listeners.
			@private
			@param inst {object} The instance settings.
			@param value {string} The new value. */
		_setValue: function(inst, value) {
			if (value !== inst.elem.val()) {
				if (inst.options.altField) {
					$(inst.options.altField).val(!value ? '' : this._formatDatetime(inst,
						inst.options.altFormat || inst.options.datetimeFormat));
				}
				inst.elem.val(value).trigger('change');
			}
		},

		/** Move to previous/next field, or out of field altogether if appropriate.
			@private
			@param inst {object} The instance settings.
			@param offset {number} The direction of change (-1, +1).
			@param moveOut {boolean} True if can move out of the field.
			@return {boolean} True if exiting the field, false if not. */
		_changeField: function(inst, offset, moveOut) {
			var atFirstLast = (inst.elem.val() === '' ||
				inst._field === (offset === -1 ? 0 : inst._fields.length - 1));
			if (!atFirstLast) {
				inst._field += offset;
			}
			this._showField(inst);
			inst._lastChr = '';
			return (atFirstLast && moveOut);
		},

		/** Update the current field in the direction indicated.
			@private
			@param inst {object} The instance settings.
			@param offset {number} The amount to change by. */
		_adjustField: function(inst, offset) {
			if (inst.elem.val() === '') {
				offset = 0;
			}
			var field = inst.options.datetimeFormat.charAt(inst._fields[inst._field]);
			var year = inst._selectedYear + (field.match(/y/i) ? offset : 0);
			var month = inst._selectedMonth + (field.match(/o|n/i) ? offset : 0);
			var day = (field.match(/d|w/i) ? inst._selectedDay + offset :
				Math.min(inst._selectedDay, this._getDaysInMonth(year, month)));
			var timeSteps = inst.options.timeSteps;
			var hour = inst._selectedHour + (field.match(/h/i) ? offset * timeSteps[0] : 0) +
				(field === 'a' && offset !== 0 ? (inst._selectedHour < 12 ? +12 : -12) : 0);
			var minute = inst._selectedMinute + (field.match(/m/i) ? offset * timeSteps[1] : 0);
			var second = inst._selectedSecond + (field.match(/s/i) ? offset * timeSteps[2] : 0);
			this._setDatetime(inst, new Date(year, month, day, hour, minute, second));
		},

		/** Find the number of days in a given month.
			@private
			@param year {number} The full year.
			@param month {number} The month (0 to 11).
			@return {number} The number of days in this month. */
		_getDaysInMonth: function(year, month) {
			return new Date(year, month + 1, 0, 12).getDate();
		},

		/** Check against minimum/maximum and display date/time.
			@private
			@param inst {object} The instance settings.
			@param datetime {Date|number|string} An actual date or offset in seconds from now or
						units and periods of offsets from now. */
		_setDatetime: function(inst, datetime) {
			// Normalise to base time
			datetime = this._normaliseDatetime(this._determineDatetime(inst,
				datetime || inst.options.defaultDatetime) || new Date());
			var fields = this._constrainTime(inst,
				[datetime.getHours(), datetime.getMinutes(), datetime.getSeconds()]);
			datetime.setHours(fields[0], fields[1], fields[2]);
			var minDatetime = this._normaliseDatetime(
				this._determineDatetime(inst, inst.options.minDatetime));
			var maxDatetime = this._normaliseDatetime(
				this._determineDatetime(inst, inst.options.maxDatetime));
			var minTime = this._normaliseDatetime(
				this._determineDatetime(inst, inst.options.minTime), 'd');
			var maxTime = this._normaliseDatetime(
				this._determineDatetime(inst, inst.options.maxTime), 'd');
			// Ensure it is within the bounds set
			datetime = (minDatetime && datetime < minDatetime ? minDatetime :
				(maxDatetime && datetime > maxDatetime ? maxDatetime : datetime));
			if (minTime && this._normaliseDatetime(new Date(datetime.getTime()), 'd') < minTime) {
				this._copyTime(minTime, datetime);
			}
			if (maxTime && this._normaliseDatetime(new Date(datetime.getTime()), 'd') > maxTime) {
				this._copyTime(maxTime, datetime);
			}
			inst._selectedYear = datetime.getFullYear();
			inst._selectedMonth = datetime.getMonth();
			inst._selectedDay = datetime.getDate();
			inst._selectedHour = datetime.getHours();
			inst._selectedMinute = datetime.getMinutes();
			inst._selectedSecond = datetime.getSeconds();
			this._showDatetime(inst);
		},

		/** Copy just the date portion of a date/time.
			@private
			@param dateFrom {Date} The date/time to copy from.
			@param dateTo {Date} The date/time to copy to. */
		_copyDate: function(dateFrom, dateTo) {
			dateTo.setFullYear(dateFrom.getFullYear());
			dateTo.setMonth(dateFrom.getMonth());
			dateTo.setDate(dateFrom.getDate());
		},

		/** Copy just the time portion of a date/time.
			@private
			@param timeFrom {Date} The date/time to copy from.
			@param timeTo {Date} The date/time to copy to. */
		_copyTime: function(timeFrom, timeTo) {
			timeTo.setHours(timeFrom.getHours());
			timeTo.setMinutes(timeFrom.getMinutes());
			timeTo.setSeconds(timeFrom.getSeconds());
		},

		/** A date/time may be specified as an exact value or a relative one.
			@private
			@param inst {object) the instance settings.
			@param setting {Date|number|string} An actual date/time or offset in seconds/days from now or
					units and periods of offsets from now.
			@return {Date) The calculated date/time. */
		_determineDatetime: function(inst, setting) {
			var offsetNumeric = function(offset) { // E.g. +300, -2
				var datetime = new Date();
				datetime.setSeconds(datetime.getSeconds() + offset);
				return datetime;
			};
			var offsetString = function(offset) { // E.g. '+2m', '-4h', '+3h +30m'
				var datetime;
				try { // Check for string in current datetime format
					datetime = plugin._parseDatetime(inst, offset);
					if (datetime) {
						return datetime;
					}
				}
				catch (e) {
					// Ignore
				}
				offset = offset.toLowerCase();
				datetime = new Date();
				var year = datetime.getFullYear();
				var month = datetime.getMonth();
				var day = datetime.getDate();
				var hour = datetime.getHours();
				var minute = datetime.getMinutes();
				var second = datetime.getSeconds();
				var pattern = /([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g;
				var matches = pattern.exec(offset);
				while (matches) {
					switch (matches[2] || 's') {
						case 's':
							second += parseInt(matches[1], 10); break;
						case 'm':
							minute += parseInt(matches[1], 10); break;
						case 'h':
							hour += parseInt(matches[1], 10); break;
						case 'd':
							day += parseInt(matches[1], 10); break;
						case 'w':
							day += parseInt(matches[1], 10) * 7; break;
						case 'o':
							month += parseInt(matches[1], 10); break;
						case 'y':
							year += parseInt(matches[1], 10); break;
					}
					matches = pattern.exec(offset);
				}
				return new Date(year, month, day, hour, minute, second);
			};
			return (setting ? (typeof setting === 'string' ? offsetString(setting) :
				(typeof setting === 'number' ? offsetNumeric(setting) : setting)) : null);
		},

		/** Normalise date/time object.
			@private
			@param datetime {Date} The original date/time.
			@param type {string} 'd' for retain date only, 't' for retain time only, <code>null</code> for neither.
			@return {Date} The normalised date/time. */
		_normaliseDatetime: function(datetime, type) {
			if (!datetime) {
				return null;
			}
			if (type === 'd') {
				datetime.setFullYear(0);
				datetime.setMonth(0);
				datetime.setDate(0);
			}
			if (type === 't') {
				datetime.setHours(12);
				datetime.setMinutes(0);
				datetime.setSeconds(0);
			}
			datetime.setMilliseconds(0);
			return datetime;
		},

		/** Retrieve the short year cutoff value.
			@private
			@param inst {object} The instance settings.
			@return {number} The calculated cutoff year. */
		_shortYearCutoff: function(inst) {
			var cutoff = inst.options.shortYearCutoff;
			if (typeof cutoff === 'string') {
				cutoff = new Date().getFullYear() + parseInt(cutoff, 10);
			}
			return cutoff % 100;
		},

		/** Constrain the given/current time to the time steps.
			@private
			@param inst {object} The instance settings.
			@param fields {number[]} The current time components (hours, minutes, seconds).
			@return {number[]} The constrained time components (hours, minutes, seconds). */
		_constrainTime: function(inst, fields) {
			var specified = (fields !== null && fields !== undefined);
			if (!specified) {
				var now = this._determineTime(inst, inst.options.defaultTime) || new Date();
				fields = [now.getHours(), now.getMinutes(), now.getSeconds()];
			}
			var reset = false;
			var timeSteps = inst.options.timeSteps;
			for (var i = 0; i < timeSteps.length; i++) {
				if (reset) {
					fields[i] = 0;
				}
				else if (timeSteps[i] > 1) {
					fields[i] = Math.round(fields[i] / timeSteps[i]) * timeSteps[i];
					reset = true;
				}
			}
			return fields;
		}
	});
	
	var plugin = $.datetimeEntry;

})(jQuery);
