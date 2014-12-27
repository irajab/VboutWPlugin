<?php

global $post_id;

$post_type = get_post_type();
$post_list = array(); //$this->get_post_list( $post_type, $post_id );


///	ADD META POST/PAGE TO CHECK IF THIS POST/PAGE IS ALREADY SENT TO VBOUT
//$hasp_expire_enable = get_post_meta( $post_id, 'hasp_expire_enable', true );

?>

<div id="vbout_post_to_channels_box" class="postbox">
	<h3>
		<input type="checkbox" name="vb_post_to_channels" id="vb_post_to_channels" /><?php _e( 'Post to social channels?', 'vblng' ); ?>
	</h3>

	<div class="inside">
		here...
	</div>
</div>


<div id="hasp_expire_div" style="display: none;">

	<span><input type="text" id="hasp_expire_date" name="hasp_expire_date" size="13" placeholder="<?php _e( 'Y-m-d H:i', 'hasp' ) ?>" value="<?php echo $hasp_expire_date ?>"></span>
	<span id="hasp_expire_error_1" class="hasp_error_mes" style="display: none"><?php _e( 'Input datetime.', 'hasp' ) ?></span>
	<span id="hasp_expire_error_2" class="hasp_error_mes" style="display: none"><?php _e( 'Input future datetime.', 'hasp' ) ?></span>
	
</div>

<p><label><input type="checkbox" name="hasp_overwrite_enable" id="hasp_overwrite_enable" <?php if( $hasp_overwrite_enable == 1 ) echo 'checked="checked"'; ?>><?php _e( 'Overwrite the another post', 'hasp' ) ?></label></p>

<div id="hasp_overwrite_div" style="display: none;">

	<select name="hasp_overwrite_post_id" id="hasp_overwrite_post_id">
		<option value="0">— <?php _e( 'Select' ) ?> —</option>
		<?php foreach( $post_list as $post ) : ?>
			<option value="<?php echo $post->ID ?>" <?php if( $hasp_overwrite_post_id == $post->ID ) echo 'selected'?>><?php echo $post->post_title ?></option>
		<?php endforeach; ?>
	</select>
	<span id="hasp_overwrite_error" class="hasp_error_mes" style="display: none"><?php _e( 'Select the post.', 'hasp' ) ?></span>
	<p><?php _e( 'You can set schedule which overwrites the another post.', 'hasp' ) ?></p>
</div>