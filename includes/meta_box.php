<?php
$post_type = get_post_type();

$postId = $_GET['id'];
	
$post = get_post($postId);

?>
<p style="background-color: #ffe9e9; border: 2px solid red; font-size: 14px; font-weight: bold; margin: 10px 0; padding: 5px;">
	N.B. <span style="color: red;">The <?php echo ucfirst($post_type); ?> will be sent once you press the publish button.</span>
</p>

<?php if ($socialMediaActivated && $channels != NULL): ?>
<div id="vbout_post_to_channels_box" class="postbox">
	<h3>
		<span>
			<label><input type="checkbox" name="vb_post_to_channels" id="vb_post_to_channels" /><?php _e( 'Post to social media?', 'vblng' ); ?></label>
		</span>
	</h3>

	<div class="inside" style="display: none;">
		<p>Please choose which social channel you want to post to:</p>
		<table class="form-table">
			<?php	if (isset($channels['Facebook']) && $channels['Facebook'] != NULL): ?>
			<tr scope="row">
				<th>Facebook:</th>
				<td>
					<select name="channels[facebook][]" class="chosen-select channels" multiple="multiple">
					<?php	foreach($channels['Facebook'] as $page): ?>
						<?php	if (!isset($channels['default']['Facebook']) || (isset($channels['default']['Facebook']) && in_array($page['value'], $channels['default']['Facebook']))): ?>
						<option value="<?php echo $page['value']; ?>"><?php echo $page['label']; ?></option>
						<?php	endif; ?>
					<?php	endforeach; ?>
					</select>
				</td>
			</tr>
			<?php	endif; ?>
			
			<?php	if (isset($channels['Twitter']) && $channels['Twitter'] != NULL): ?>
			<tr scope="row">
				<th>Twitter:</th>
				<td>
					<select name="channels[twitter][]" class="chosen-select channels" multiple="multiple">
					<?php	foreach($channels['Twitter'] as $profile): ?>
						<?php	if (!isset($channels['default']['Twitter']) || (isset($channels['default']['Twitter']) && in_array($profile['value'], $channels['default']['Twitter']))): ?>
						<option value="<?php echo $profile['value']; ?>"><?php echo $profile['label']; ?></option>
						<?php	endif; ?>
					<?php	endforeach; ?>
					</select>
				</td>
			</tr>
			<?php	endif; ?>
			
			<?php	if (isset($channels['Linkedin']) && $channels['Linkedin'] != NULL): ?>
			<tr scope="row">
				<th>Linkedin:</th>
				<td>
					<select name="channels[linkedin][]" class="chosen-select channels" style="width:350px;" multiple="multiple">
					<?php	foreach($channels['Linkedin'] as $profile): ?>
						<?php	if (!isset($channels['default']['Linkedin']) || (isset($channels['default']['Linkedin']) && in_array($profile['value'], $channels['default']['Linkedin']))): ?>
						<option value="<?php echo $profile['value']; ?>"><?php echo $profile['label']; ?></option>
						<?php	endif; ?>
					<?php	endforeach; ?>
					</select>
				</td>
			</tr>
			<?php	endif; ?>

			<tr scope="row">
				<th scope="row">
					<label for="vb_post_schedule_shortenurls"><?php _e( 'Use tracking URLs?', 'vblng' ); ?></label>
					<img class="alignright vb_tooltip" alt="The link to this post will be masked with a tracking url, <br />ex: https://www.vbout.com/goto/UO  so we can track clicks and social media conversion." src="<?php echo VBOUT_URL; ?>/images/tooltip-icon.png" style="cursor: pointer;" />
				</th>
				<td>
					<label for="vb_post_schedule_shortenurls">
						<input type="checkbox" name="vb_post_schedule_shortenurls" id="vb_post_schedule_shortenurls" value="yes" />
					</label>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php endif; ?>

<?php if ($emailMarketingActivated): ?>
<div id="vbout_post_to_campaign_box" class="postbox">
	<h3>
		<span>
			<label><input type="checkbox" name="vb_post_to_campaign" id="vb_post_to_campaign" /><?php _e( 'Send as an email campaign?', 'vblng' ); ?></label>
		</span>
	</h3>

	<div class="inside" style="display: none;">
		<table class="form-table">
			<tr scope="row">
				<th><?php _e( 'Choose list to email the campaign to:', 'vblng' ); ?></th>
				<td>
					<?php if (isset($lists['lists']) && $lists['lists'] != NULL): ?>
					<select id="campaigns" class="chosen-select" style="width:350px;" tabindex="2" name="campaign[]" multiple="multiple">
					<?php	foreach($lists['lists'] as $list): ?>
					<?php		if (($lists['default'] == NULL) || ($lists['default'] != NULL && in_array($list['value'], $lists['default']))): ?>
						<option value="g_<?php echo $list['value']; ?>"><?php echo $list['label']; ?></option>
					<?php		endif; ?>
					<?php	endforeach; ?>
					</select>
					<?php endif; ?>
				</td>
			</tr>

			<tr scope="row">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_emailsubject"><?php _e( 'Email Name', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_emailname" id="vb_post_schedule_emailname" value="<?php echo (get_option('vbout_em_emailname') != '')?get_option('vbout_em_emailname'):((isset($_GET['action']) && $_GET['action'] == 'edit')?$post->post_title:''); ?>" class="regular-text" />
				</td>
			</tr>
			
			<tr scope="row">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_emailsubject"><?php _e( 'Email Subject', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_emailsubject" id="vb_post_schedule_emailsubject" value="<?php echo (get_option('vbout_em_emailsubject') != '')?get_option('vbout_em_emailsubject'):((isset($_GET['action']) && $_GET['action'] == 'edit')?$post->post_title:''); ?>" class="regular-text" />
				</td>
			</tr>
			
			<tr scope="row">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_fromemail"><?php _e( 'From Email', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_fromemail" id="vb_post_schedule_fromemail" value="<?php echo get_option('vbout_em_fromemail'); ?>" class="regular-text" />
				</td>
			</tr>
			
			<tr scope="row">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_fromname"><?php _e( 'From Name', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_fromname" id="vb_post_schedule_fromname" value="<?php echo get_option('vbout_em_fromname'); ?>" class="regular-text" />
				</td>
			</tr>
			
			<tr scope="row">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_replyto"><?php _e( 'Reply to', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_replyto" id="vb_post_schedule_replyto" value="<?php echo get_option('vbout_em_replyto'); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
	</div>
</div>
<?php endif; ?>

<div>
	<table class="form-table">
		<tr scope="row">
			<th scope="row">
				<label for="vb_post_schedule_isscheduled"><?php _e( 'Do you wish to schedule it for the future?', 'vblng' ); ?></label>
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
				<select name="vb_post_schedule_time[Hours]" id="vb_post_schedule_time_hours">
					<option selected="selected" value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				&nbsp;&nbsp;
				<select name="vb_post_schedule_time[Minutes]" id="vb_post_schedule_time_minutes">
					<option selected="selected" value="00">00</option>
					<option value="05">05</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
					<option value="25">25</option>
					<option value="30">30</option>
					<option value="35">35</option>
					<option value="40">40</option>
					<option value="45">45</option>
					<option value="50">50</option>
					<option value="55">55</option>
				</select>
				&nbsp;
				<input checked="checked" type='radio' class='' id='TimeAmPm_Am' name='vb_post_schedule_time[TimeAmPm]' value="am"><label for='TimeAmPm_Am'>AM</label>
				<input type='radio' class='' id='TimeAmPm_Pm' name='vb_post_schedule_time[TimeAmPm]' value="pm"><label for='TimeAmPm_Pm'>PM</label>
			</td>
		</tr>
	</table>
</div>

<!-- SET THIS SCRIPT IN THE BOTTOM OF THE PAGE AND NOT HERE.... -->
<script type="text/javascript">
	jQuery(document).ready(function() { 
		jQuery('.chosen-select').chosen({'width':'90%'});
		
		jQuery('#publish').click(function() { 
			var submitToVbout = true;
			var submitToVboutErrMessage = '';
			
			if (jQuery('#vb_post_to_channels').attr('checked') && jQuery('.channels option:selected').length == 0) {
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