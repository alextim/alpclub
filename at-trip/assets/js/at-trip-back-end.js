(function( $ ) {
		$('#trip-registration-end-date').datepicker({
			//language: 'en',
			minDate: new Date()
		});
		
		$('#trip-start-date').datepicker({
			//language: 'en',
			minDate: new Date()
		});
		
		$('#trip-end-date').datepicker({
			//language: 'en',
			minDate: new Date()
		});
/*
	    function dateTimePicker() {

        if ($.fn.datepicker) {
            $('#trip-start-date').datepicker({
                //language: 'en',
                minDate: new Date(),
                onSelect: function(dateStr) {
                    newMinDate = null;
                    newMaxDate = new Date();
                    if ('' !== dateStr) {
                        new_date_min = new Date(dateStr);

                        newMinDate = new Date(new_date_min.setDate(new Date(new_date_min.getDate())));
                    }
                    $('#trip-end-date').datepicker({
                        minDate: newMinDate,
                    });
                }
            });

            $('#trip-end-date').datepicker({
                //language: 'en',
                minDate: new Date()
            });

            $('.trip-datepicker').datepicker({
                //language: 'en',
                minDate: new Date()
            });

            $('.trip-timepicker').datepicker({
                // language: 'en',
                timepicker: true,
                onlyTimepicker: true,

            });
        }
    }
    dateTimePicker();
*/
    $(document).on('click', '#publish', function() {

        var start_date = $('#trip-start-date').val();
        var end_date = $('#trip-end-date').val();

        var error = '';
        if ('' != start_date || '' != end_date) {
            if ('' == start_date) {
                error += 'Start date can\'t be empty!' + "\n";
            }
            if ('' == end_date) {
                error += 'End date can\'t be empty!' + "\n";
            }

            if ('' != start_date && '' != end_date) {
                start_date = new Date(start_date);
                end_date = new Date(end_date);

                if (end_date <= start_date) {
                    error += 'End date must greater than start date.' + "\n";
                }
            }

        }

        if ('' == error) {
            $(document).off('click', '#publish');
        } else {
            alert(error);
            return false;
        }
    });
	
	
	
	$(document).on('click', '#trip-fixed-departure', function() {
		if ($(this).is(':checked')) {
			$('.trip-fixed-departure-row').css({ 'display': 'table-row' });
			$('.trip-duration-row').css({ 'display': 'none' });
		} else {
			$('.trip-fixed-departure-row').css({ 'display': 'none' });
			$('.trip-duration-row').css({ 'display': 'table-row' });
		}
	});
	
	$(document).on('click', '#trip-enable-sale', function() {
		if ($(this).is(':checked')) {
			$('.trip-sale-price-row').css({ 'display': 'table-row' });
		} else {
			$('.trip-sale-price-row').css({ 'display': 'none' });
		}
	});
	
	$(document).on('click', '#trip-registration-enabled', function() {
		if ($(this).is(':checked')) {
			$('.trip-registration-row').css({ 'display': 'table-row' });
		} else {
			$('.trip-registration-row').css({ 'display': 'none' });
		}
	});

})( jQuery );


