(function($) {

	/**
	 * INSERT FORM
	 */
	var form  = $('#add-form'),
		list  = $('#item-list'),
	    input = form.find('#text');

	input.val('').focus();
	$('.submit-button').hide();


	/**
	 * SETTINGS
	 */
	var animation = {
		startColor: '#00bc8c',
		endColor: list.find('li').css('backgroundColor') || '#303030',
		delay: 200
	}


	form.on('submit', function(event) {
		event.preventDefault();

		var req = $.ajax({
			url: form.attr('action'),
			type: 'POST',
			data: form.serialize(),
			dataType: 'json'
		});

		req.done(function(data) {
			if ( data.status === 'success' ) {
				$.ajax({ url: baseURL }).done(function(html) {
					var newItem = $(html).find('#item-' + data.id);

					newItem.appendTo( list )
						.css({ backgroundColor: animation.startColor })
						.delay( animation.delay )
						.animate({ backgroundColor: animation.endColor });

					input.val('').focus();
				});
			}
		});
	});

	input.on('keypress', function(event) {
		if ( event.which === 13 ) {
			form.submit();
			return false;
		}
	});


	/**
	 * EDIT FORM
	 */
	$('#edit-form').find('#text').select();


	/**
	 * DELETE FORM
	 */
	$('#delete-form').on('submit', function(event) {
		return confirm('for sure?');
	});


}(jQuery));