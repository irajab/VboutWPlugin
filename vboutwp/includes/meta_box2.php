<?php
	$postId = $_GET['id'];
	
	$post = get_post($postId);
?>
<div class="wrap">
	<h2>Send to Vbout: <?php echo $post->post_title; ?></h2>

	<p><?php echo $post->post_content; ?></p>
	
	<form method="post" action="options.php">
		<input type="hidden" name="post_id" value="<?php echo $postId; ?>" />
		<input type="hidden" name="option_page" value="vbout-schedule" />
		<input type="hidden" name="action" value="update" />
		<?php echo wp_nonce_field('vbout-schedule-options', '_wpnonce', true, false); ?>
			
		<div id="vbout_post_to_channels_box" class="postbox" style="padding: 0 10px;">
			<h3>
				<span>
					<label><input type="checkbox" name="vb_post_to_channels" id="vb_post_to_channels" /><?php _e( 'Post to social channels?', 'vblng' ); ?></label>
				</span>
			</h3>

			<div class="inside" style="display: none;">
				<p>Please choose which social channel you want to post to:</p>
				<table class="form-table">
					<?php if (is_array($channels)): ?>
					<?php	foreach($channels as $channelName => $channelAttrs): ?>
					<?php		if ($channelAttrs['count'] > 0): ?>
					<?php			if (strtolower($channelName) == 'facebook'): ?>
					<tr scope="row">
						<th>Facebook:</th>
						<td>
							<fieldset>
					<?php				foreach($channelAttrs['pages'] as $page): ?>
							<label title="<?php echo $page['name']; ?>">
								<input class="channels" type="checkbox" value="<?php echo $page['id']; ?>" name="channels[facebook][]">
								<span><?php echo $page['name']; ?></span>
							</label>
					<?php				endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<?php			elseif (strtolower($channelName) == 'twitter'): ?>
					<tr scope="row">
						<th>Twitter:</th>
						<td>
							<fieldset>
					<?php				foreach($channelAttrs['profiles'] as $profile): ?>
							<label title="<?php echo $profile['fullname']; ?>">
								<input class="channels" type="checkbox" value="<?php echo $profile['id']; ?>" name="channels[twitter][]">
								<span><?php echo $profile['fullname']; ?></span>
							</label>
					<?php				endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<?php			elseif (strtolower($channelName) == 'linkedin'): ?>
					<tr scope="row">
						<th>Linkedin:</th>
						<td>
							<fieldset>
					<?php				foreach($channelAttrs['profiles'] as $profile): ?>
							<label title="<?php echo $profile['fullname']; ?>">
								<input class="channels" type="checkbox" value="<?php echo $profile['id']; ?>" name="channels[linkedin][]">
								<span><?php echo $profile['fullname']; ?></span>
							</label>
					<?php				endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<?php			endif; ?>
					<?php		endif; ?>
					<?php	endforeach; ?>
					<?php endif; ?>
				</table>
			</div>
		</div>

		<div id="vbout_post_to_campaign_box" class="postbox" style="padding: 0 10px;">
			<h3>
				<span>
					<label><input type="checkbox" name="vb_post_to_campaign" id="vb_post_to_campaign" /><?php _e( 'Post as campaign?', 'vblng' ); ?></label>
				</span>
			</h3>

			<div class="inside" style="display: none;">
				<table class="form-table">
					<tr scope="row">
						<th>Please choose which lists you want to post to:</th>
						<td>
							<?php if (isset($lists['count']) && $lists['count'] > 0): ?>
							<select id="campaigns" data-placeholder="Choose a List..." class="chosen-select" style="width:350px;" tabindex="2" name="campaign[]" multiple>
							<?php	foreach($lists['items'] as $list): ?>
								<option value="g_<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option>
							<?php	endforeach; ?>
							</select>
							<?php endif; ?>
						</td>
					</tr>

					<tr scope="row">
						<th scope="row" style="width: auto;">
							<label for="vb_post_schedule_emailsubject"><?php _e( 'Email Subject', 'vblng' ); ?></label>
						</th>
						<td>
							<input type="text" name="vb_post_schedule_emailsubject" id="vb_post_schedule_emailsubject" value="" class="regular-text" />
						</td>
					</tr>
					
					<tr scope="row">
						<th scope="row" style="width: auto;">
							<label for="vb_post_schedule_fromemail"><?php _e( 'From Email', 'vblng' ); ?></label>
						</th>
						<td>
							<input type="text" name="vb_post_schedule_fromemail" id="vb_post_schedule_fromemail" value="" class="regular-text" />
						</td>
					</tr>
					
					<tr scope="row">
						<th scope="row" style="width: auto;">
							<label for="vb_post_schedule_fromname"><?php _e( 'From Name', 'vblng' ); ?></label>
						</th>
						<td>
							<input type="text" name="vb_post_schedule_fromname" id="vb_post_schedule_fromname" value="" class="regular-text" />
						</td>
					</tr>
					
					<tr scope="row">
						<th scope="row" style="width: auto;">
							<label for="vb_post_schedule_replyto"><?php _e( 'Reply to', 'vblng' ); ?></label>
						</th>
						<td>
							<input type="text" name="vb_post_schedule_replyto" id="vb_post_schedule_replyto" value="" class="regular-text" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div>
			<table class="form-table">
				<tr scope="row">
					<th scope="row">
						<label for="vb_post_schedule_isscheduled"><?php _e( 'Is Scheduled?', 'vblng' ); ?></label>
					</th>
					<td>
						<label for="vb_post_schedule_isscheduled">
							<input type="checkbox" name="vb_post_schedule_isscheduled" id="vb_post_schedule_isscheduled" value="yes" />
						</label>
					</td>
				</tr>
				
				<tr scope="row" class="ScheduleDateTime" style="display: none;">
					<th scope="row" style="width: auto;">
						<label for="vb_post_schedule_date"><?php _e( 'Schedule Date', 'vblng' ); ?></label>
					</th>
					<td>
						<input type="text" name="vb_post_schedule_date" id="vb_post_schedule_date" value="" class="" />
					</td>
				</tr>

				<tr scope="row" class="ScheduleDateTime" style="display: none;">
					<th scope="row" style="width: auto;">
						<label for="vb_post_schedule_date"><?php _e( 'Schedule Time', 'vblng' ); ?></label>
					</th>
					<td>
						<input type="text" name="vb_post_schedule_time" id="vb_post_schedule_time" placeholder="HH:MM" value="" class="" />
					</td>
				</tr>

				<tr scope="row">
					<th scope="row">
						<label for="vb_post_schedule_shortenurls"><?php _e( 'Use shorten URLs', 'vblng' ); ?></label>
					</th>
					<td>
						<label for="vb_post_schedule_shortenurls">
							<input type="checkbox" name="vb_post_schedule_shortenurls" id="vb_post_schedule_shortenurls" value="yes" />
						</label>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<label>&nbsp;</label>
					</th>
					<td>
						<input type="submit" class="button-primary" id="Submit" value="Submit" />
					</td>
				</tr>
			</table>
		</div>
	</form>
</div>

<!-- SET THIS SCRIPT IN THE BOTTOM OF THE PAGE AND NOT HERE.... -->
<script type="text/javascript">
	jQuery(document).ready(function() { 
		jQuery('.chosen-select').chosen({'width':'90%'});
		
		jQuery('#Submit').click(function() { 
			var submitToVbout = true;
			var submitToVboutErrMessage = '';
			
			if (jQuery('#vb_post_to_channels').attr('checked') && jQuery('.channels:checked').length == 0) {
				submitToVbout = false;
				submitToVboutErrMessage += 'At lease choose one channel to submit to! \n';
			}
			
			if (jQuery('#vb_post_to_campaign').attr('checked')) {
				if (jQuery('#campaigns option:selected').length == 0) {
					submitToVbout = false;
					submitToVboutErrMessage += 'At lease choose one list to submit to! \n';
				}
				
				if (jQuery('#vb_post_schedule_emailsubject').val() == '') {
					submitToVbout = false;
					submitToVboutErrMessage += 'Email Subject is required! \n';
				}
				
				if (jQuery('#vb_post_schedule_fromemail').val() == '') {
					submitToVbout = false;
					submitToVboutErrMessage += 'From Email is required! \n';
				}
				
				if (jQuery('#vb_post_schedule_fromname').val() == '') {
					submitToVbout = false;
					submitToVboutErrMessage += 'From Name is required! \n';
				}
				
				if (jQuery('#vb_post_schedule_replyto').val() == '') {
					submitToVbout = false;
					submitToVboutErrMessage += 'Reply to is required! \n';
				}
			}
			
			if (!submitToVbout)
				alert(submitToVboutErrMessage);
	
			return submitToVbout;
		});
		
		jQuery('#vb_post_schedule_date').datepicker({
			dateFormat : 'mm/dd/yy',
			changeMonth: true,
			changeYear: true
		});
		
		jQuery('#vb_post_schedule_isscheduled').change(function() { 
			if (!jQuery(this).attr('checked')) {
				jQuery('.ScheduleDateTime').hide();
			} else {
				jQuery('.ScheduleDateTime').show();
			}
		});
		
		jQuery('#vb_post_to_channels').change(function() { 
			if (!jQuery(this).attr('checked')) {
				jQuery('#vbout_post_to_channels_box .inside').hide();
			} else {
				jQuery('#vbout_post_to_channels_box .inside').show();
			}
		});
		
		jQuery('#vb_post_to_campaign').change(function() { 
			if (!jQuery(this).attr('checked')) {
				jQuery('#vbout_post_to_campaign_box .inside').hide();
			} else {
				jQuery('#vbout_post_to_campaign_box .inside').show();
			}
		});
	});
</script>