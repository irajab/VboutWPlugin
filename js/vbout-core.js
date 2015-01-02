(function($){
	$(document).ready(function() { 
		$('.chosen-select').chosen({'width':'50%'});
		
		$('#Vbout-settings-tabs a').click(function(e) { 
			e.preventDefault();
			
			$('#Vbout-settings-tabs a').removeClass('nav-tab-active');
			$(this).addClass('nav-tab-active');
			
			
			$('.tabs-panel').removeClass('tabs-panel-active').addClass('tabs-panel-inactive');
			$('#'+$(this).attr('data-tab')).removeClass('tabs-panel-inactive').addClass('tabs-panel-active');
		});
		
		$('.sliderButton').click(function() { 
			$('#vbout-connect').find('[type=submit]').show();
			
			if (!$('#'+$(this).attr('data-slider')).is(':visible')) {
				$('.vbout_slider_box').slideUp();
				
				$('#'+$(this).attr('data-slider')).slideToggle();
				
				$('[name=vbout_method]').val($(this).attr('data-method'));
			}
		});
		
		if ($('#vbout-connect').length) {
			$('#vbout-connect').find('[type=submit]').hide();
			
			$('#vbout-connect').submit(function() { 
				var returnVar = true;
				
				$('#vbout-connect').find('.error_placeholder').remove();
				
				if ($('#UserKeySlider').is(':visible') && $('#vbout_userkey').val() == '') {
					$('#vbout_userkey').after('<p style="color: red;" class="error_placeholder">This field is required.</p>');

					returnVar = false;
				} else if ($('#AppKeySlider').is(':visible') && ($('#vbout_appkey').val() == '' || $('#vbout_clientsecret').val() == '' || $('#vbout_authtoken').val() == '')) {
					$('#AppKeySlider').find('input[type=text]').each(function() { 
						if ($(this).val() == '')
							$(this).after('<p style="color: red;" class="error_placeholder">This field is required.</p>');
					});
					
					returnVar = false;
				} else if (!$('#UserKeySlider').is(':visible') && !$('#AppKeySlider').is(':visible')) {
					alert('Please choose a method to connect to Vbout.');
					returnVar = false;
				}
				
				return returnVar;
			});
			
			if ($('#message').length) {
				$('[data-method='+$('[name=vbout_method]').val()+']').trigger('click');
			}
		}
	});
})(jQuery)