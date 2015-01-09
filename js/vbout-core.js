function triggerLivePreview(ed)
{
	//	FACEBOOK SHARE LINK
	//	*******************
	var hasShare = false;
	
	// IF HAS IMAGE DON'T SHOW THE SHARE BOX
	//get the first image
	var content = jQuery('<div>'+ ed.getContent() + '</div>');
	var imageUrl = jQuery('img:first', content).attr('src');
	var imageAlt = jQuery('img:first', content).attr('alt');
	
	triggerImagePreview(imageUrl);
	
	if (ed.getContent() == '') {
		jQuery(".facebook_livepreview_box .userContent").html('Please insert a text to share...');
		jQuery(".twitter_livepreview_box .ProfileTweet-text").html('Please insert a text to share...');
		jQuery(".linkedin_livepreview_box .share-body").html('Please insert a text to share...');
	} else {
		jQuery(".facebook_livepreview_box .userContent").html(ed.getContent().replace(/(<([^>]+)>)/ig,"").substring(0, 255));
		jQuery(".twitter_livepreview_box .ProfileTweet-text").html(ed.getContent().replace(/(<([^>]+)>)/ig,"").substring(0, 255));
		jQuery(".linkedin_livepreview_box .share-body").html(ed.getContent().replace(/(<([^>]+)>)/ig,"").substring(0, 255));
	}
	
	if (imageUrl == undefined) {
		jQuery('[name=photo_url]').val('');
		jQuery('[name=photo_alt]').val('');
		
		jQuery('.facebook_livepreview_box .shareHeaderTitle').hide();
		jQuery('.linkedin_livepreview_box .share-title').hide();
		
		jQuery('.facebook_livepreview_box .shareHeaderLink').hide();
		jQuery('.linkedin_livepreview_box .share-link').hide();
				
		jQuery('.facebook_livepreview_box .shareHeaderContent').hide();
		jQuery('.linkedin_livepreview_box .description').hide();
	
		jQuery('.facebook_livepreview_box .shareLink img').hide();
		jQuery('.linkedin_livepreview_box .share-object .image').hide();
	} else {
		jQuery('[name=photo_url]').val(imageUrl);
				
		if (imageAlt != 'undefined') {
			hasShare = true;
			
			jQuery('[name=photo_alt]').val(imageAlt);
			
			jQuery('.facebook_livepreview_box .shareHeaderTitle').html(imageAlt);
			jQuery('.facebook_livepreview_box .shareHeaderTitle').show();
			
			jQuery('.linkedin_livepreview_box .share-title .title').html(imageAlt);
			jQuery('.linkedin_livepreview_box .share-title').show();
			
			console.log('hasTitle');
		} else {
			jQuery('[name=photo_alt]').val('');
			
			jQuery('.facebook_livepreview_box .shareHeaderTitle').hide();
			jQuery('.linkedin_livepreview_box .share-title').hide();
		}
		
		if (jQuery('[name=post_url]').val() != '') {
			hasShare = true; 
			
			jQuery('.facebook_livepreview_box .shareHeaderLink').html(jQuery('[name=post_url]').val());
			jQuery('.facebook_livepreview_box .shareHeaderLink').show();
			
			jQuery('.linkedin_livepreview_box .share-link').html(jQuery('[name=post_url]').val());
			jQuery('.linkedin_livepreview_box .share-link').show();
			
			console.log('hasURL');
		} else {
			jQuery('.facebook_livepreview_box .shareHeaderLink').hide();
			jQuery('.linkedin_livepreview_box .share-link').hide();
		}
		
		if (imageUrl != undefined) {
			jQuery('.facebook_livepreview_box .shareLink img').attr('src', imageUrl);
			jQuery('.facebook_livepreview_box .shareLink img').show();
			
			jQuery('.linkedin_livepreview_box .share-object .image img').attr('src', imageUrl);
			jQuery('.linkedin_livepreview_box .share-object .image').show();
			
			console.log('hasPreview');
		} else {
			jQuery('.facebook_livepreview_box .shareLink img').hide();
			jQuery('.linkedin_livepreview_box .share-object .image').hide();
		}
	}

	if (hasShare) {
		jQuery('.facebook_livepreview_box .photo').hide();
		
		jQuery('.facebook_livepreview_box .share').show();
		jQuery('.linkedin_livepreview_box .share-object').show();
	} else {
		if (imageUrl != undefined) {
			jQuery('.facebook_livepreview_box .photo').show();
		}
		
		jQuery('.facebook_livepreview_box .share').hide();
		jQuery('.linkedin_livepreview_box .share-object').hide();
	}
}

function triggerImagePreview(ImageId)
{
	if (ImageId == undefined) {
		// NO IMAGE
		jQuery('.facebook_livepreview_box .scaledImage .img').attr('src', '');
		jQuery('.facebook_livepreview_box .photo').hide();
		
		jQuery('.twitter_livepreview_box .TwitterPhoto-mediaSource').attr('src', '');
		jQuery('.twitter_livepreview_box .TwitterPhoto-media').hide();
		
		jQuery('.linkedin_livepreview_box .share-object .image img').attr('src', '');
		jQuery('.linkedin_livepreview_box .share-object .image').hide();
		jQuery('.linkedin_livepreview_box .share-object').hide();
	} else {
		// AN IMAGE
		jQuery('.facebook_livepreview_box .scaledImage .img').attr('src', ImageId);
		jQuery('.facebook_livepreview_box .photo').show();
		
		jQuery('.twitter_livepreview_box .TwitterPhoto-mediaSource').attr('src', ImageId);
		jQuery('.twitter_livepreview_box .TwitterPhoto-media').show();
		
		jQuery('.linkedin_livepreview_box .share-object .image img').attr('src', ImageId);
		jQuery('.linkedin_livepreview_box .share-object .image').show();
		
		jQuery('.linkedin_livepreview_box .share-object').show();
	}
}


function triggerLiveBeforePublish(social) {
	if (social == 'facebook') {
		if (jQuery('#da-ex-buttons-checkbox input:checked').length) {
			jQuery('#FacebookLivePreview').show();
		} else {
			jQuery('#FacebookLivePreview').hide();
		}
	} else if (social == 'twitter') {
		if (jQuery('#da-ex-buttons-checkbox1 input:checked').length) {
			jQuery('#TwitterLivePreview').show();
		} else {
			jQuery('#TwitterLivePreview').hide();
		}
	} else if (social == 'linkedin') {
		if (jQuery('#da-ex-buttons-checkbox2 input:checked').length) {
			jQuery('#LinkedinLivePreview').show();
		} else {
			jQuery('#LinkedinLivePreview').hide();
		}
	}
}

(function($){
	var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+Base64._keyStr.charAt(s)+Base64._keyStr.charAt(o)+Base64._keyStr.charAt(u)+Base64._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=Base64._keyStr.indexOf(e.charAt(f++));o=Base64._keyStr.indexOf(e.charAt(f++));u=Base64._keyStr.indexOf(e.charAt(f++));a=Base64._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
	
	$(document).ready(function() { 
		$('.chosen-select').chosen({'width':'47%'});
	
		$('.livePreviewCanvas a').click(function() {
			if ($(this).next().is(':hidden'))
				$(this).next().slideDown();
			else
				$(this).next().slideUp();
		});
		
		$('.vb_tooltip').qtip({
			content: {
				attr: 'alt'
			},
			position: {
				my: 'bottom left',
				at: 'top center'
			},
			style   : {
				tip: {
					corner: true
				},
				classes : 'qtip-bootstrap'
			},
			show    : {
				when: {
					event: 'mouseover'
				}
			},
			hide    : {
				fixed: true,
				when : {
					event: 'mouseout'
				}
			}

		});
		
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
		
		if ($('#vbout_tracking_domain').length) {
			$('#vbout_tracking_domain').change(function() { 
				$('#vbout_tracking_code').val(Base64.decode($('#trackingcode-'+$(this).val()).html()).replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&').replace(/&quot;/g,'"'));
			});
		}
		
		if ($('[name=post_title]').length) {
			$('[name=post_title]').change(function() { 
				$('#vb_post_schedule_emailsubject').val($(this).val());
			});
		}
	});
})(jQuery)