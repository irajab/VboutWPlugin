<?php

global $post_id;

$post_type = get_post_type();
$post_list = array(); //$this->get_post_list( $post_type, $post_id );


///	ADD META POST/PAGE TO CHECK IF THIS POST/PAGE IS ALREADY SENT TO VBOUT
//$hasp_expire_enable = get_post_meta( $post_id, 'hasp_expire_enable', true );

?>

<div id="vbout_post_to_channels_box" class="postbox">
	<h3>
		<span>
			<label><input type="checkbox" name="vb_post_to_channels" id="vb_post_to_channels" /><?php _e( 'Post to social channels?', 'vblng' ); ?></label>
		</span>
	</h3>

	<div class="inside">
		<p>Please choose which social channel you want to post to:</p>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td>Facebook:</td>
				<td>- NONE -</td>
			</tr>
			<tr>
				<td>Twitter:</td>
				<td>- NONE -</td>
			</tr>
			<tr>
				<td>Linkedin:</td>
				<td>- NONE -</td>
			</tr>
		</table>
	</div>
</div>

<div id="vbout_post_to_campaign_box" class="postbox">
	<h3>
		<span>
			<label><input type="checkbox" name="vb_post_to_campaign" id="vb_post_to_campaign" /><?php _e( 'Post as campaign?', 'vblng' ); ?></label>
		</span>
	</h3>

	<div class="inside">
		<p>Please choose which lists you want to post to:</p>
		<span>- NONE -</span>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_emailsubject"><?php _e( 'Email Subject', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_emailsubject" id="vb_post_schedule_emailsubject" value="" class="" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_fromemail"><?php _e( 'From Email', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_fromemail" id="vb_post_schedule_fromemail" value="" class="" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_fromname"><?php _e( 'From Name', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_fromname" id="vb_post_schedule_fromname" value="" class="" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" style="width: auto;">
					<label for="vb_post_schedule_replyto"><?php _e( 'Reply to', 'vblng' ); ?></label>
				</th>
				<td>
					<input type="text" name="vb_post_schedule_replyto" id="vb_post_schedule_replyto" value="" class="" />
				</td>
			</tr>
		</table>
	</div>
</div>

<div>
	<table class="form-table">
		<tr valign="top">
			<th scope="row" style="width: auto;">
				<label for="vb_post_schedule_date"><?php _e( 'Schedule Date', 'vblng' ); ?></label>
			</th>
			<td>
				<input type="text" name="vb_post_schedule_date" id="vb_post_schedule_date" value="" class="" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row" style="width: auto;">
				<label for="vb_post_schedule_hours"><?php _e( 'Hours', 'vblng' ); ?></label>
			</th>
			<th scope="row" style="width: auto;">
				<label for="vb_post_schedule_minutes"><?php _e( 'Minutes', 'vblng' ); ?></label>
			</th>
		</tr>
		<tr valign="top">
			<td>
				<input type="text" name="vb_post_schedule_hours" id="vb_post_schedule_hours" value="" class="" />
			</td>
			<td>
				<input type="text" name="vb_post_schedule_minutes" id="vb_post_schedule_minutes" value="" class="" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="vb_post_schedule_shortenurls"><?php _e( 'Use shorten URLs', 'vblng' ); ?></label>
			</th>
			<td>
				<label for="vb_post_schedule_shortenurls">
					<input type="checkbox" name="vb_post_schedule_shortenurls" id="vb_post_schedule_shortenurls" value="yes" />
				</label>
			</td>
		</tr>
	</table>
</div>