<?php
$post_type = get_post_type();

$postId = $_GET['id'];
	
$post = get_post($postId);

?>
<p style="background-color: #ffe9e9; border: 2px solid red; font-size: 14px; font-weight: bold; margin: 10px 0; padding: 5px;">
	N.B. <span style="color: red;">The <?php echo ucfirst($post_type); ?> will be sent once you press the publish button.</span>
</p>

<input type="hidden" name="post_title" value="<?php echo $post->post_title; ?>" />
<input type="hidden" name="post_description" value="<?php echo preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post->post_content), 0, 201)); ?>" />
<input type="hidden" name="post_url" value="<?php echo get_permalink($postId); ?>" />
<input type="hidden" name="photo_url" value="" />
<input type="hidden" name="photo_alt" value="" />

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
					
					<div class="livePreviewCanvas" id="FacebookLivePreview" style="padding-top: 15px;">
						<a href="javascript://" style="color: #9bc035; display: block; margin-bottom: 10px;">Preview before you publish</a>
						<div class="livePreviewBar" style="display: none;">
							<div class="facebook_livepreview_box">
								<div class="fbBorderTop"></div>
								<div class="timelineUnitContainer">
									<div class="">
										<div role="article">
											<div class="clearfix fbPostHeader">
												<a tabindex="0" href="javascript://" class="facebookAvatar">
													<img alt="" src="https://www.vbout.com/images/livepreview/facebook/facebook_page.png" class="_s0 _50c7 _54rt img">
												</a>
												
												<div class="headerInfo">
													<h5>
														<span class="fcg">
															<span class="fwb">
																<a href="javascript://">Facebook Page Name</a>
															</span>
														</span> 
														
														<span class="fcg"></span>
													</h5>
													
													<div class="postby fsm fwn fcg">
														<a href="javascript://" class="uiLinkSubtle">
															<abbr title="">Just Now</abbr>
														</a>
														<a href="javascript://" class="uiStreamPrivacy"><i></i></a>
													</div>
												</div>
											</div>
											
											<div class="userContentContainer">
												<div class="userContentWrapper">
													<div class="_wk">
														<span class="userContent" data-ft="{&quot;tn&quot;:&quot;K&quot;}">Please insert a text to share...</span>
													</div>
												</div>
											</div>
										</div>
										
										<a class="photo" href="javascript://" style="display: none; margin: 0 -9px;">
											<div class="letterboxedImage photoWrap" style="width:486px;height:504px; position: relative; background: #f2f2f2;">
												<div class="uiScaledImageContainer scaledImage" style="width: 336px;height: 504px;margin: 0 auto;">
													<img style="height: 100%; min-height: 100%;position: relative;" class="img" src="" style="left:0px;" alt="" width="337" height="504">
												</div>
											</div>
										</a>
										
										<div class="share" style="display: none;">
											<div class="clearfix" style="background: #f6f7f9; border: 1px solid #d3dae8; display: block; margin-bottom: 12px;">
												<a class="shareLink _1y0" href="javascript://" target="_blank" rel="nofollow" style="display: block;vertical-align: top;zoom: 1;color: #3b5998;cursor: pointer;text-decoration: none;">
													<div class="_1xy _1xx" style="overflow: hidden; border-right: 1px solid #d3dae8;float: left;height: 116px;line-height: 110px;margin-right: 11px;min-width: 140px;position: relative;text-align: center;display: block;vertical-align: top;">
														<img style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 75%; margin: auto;;" class="img" src="" alt="">
													</div>
												</a>
												
												<div class="_1xx _1xz" style="padding: 8px 11px;display: block;vertical-align: top;zoom: 1;">
													<div class="_2qo4" style="height: 98px;position: relative;">
														<a class="_2qo3" href="javascript://" target="_blank" rel="nofollow" style="color: #3b5998;cursor: pointer;text-decoration: none;">
															<div class="_1x-" style="max-height: 98px;overflow: hidden;">
																<div class="_4ysy" id="u_ps_0_0_2i">
																	<div class="_1x_ fwb shareHeaderTitle" dir="ltr" style="font-weight: bold;">Contact Us</div>
																	<div style="color: gray;font-size: 11px;" class="fsm fwn fcg shareHeaderLink">http://vbout.com/goto/A4</div>
																</div>
																
																<div style="margin-top: 8px;color: gray;" class="_1y1 _3-8x fsm fwn fcg shareHeaderContent" dir="ltr" id="u_ps_0_0_1c"></div>
															</div>
														</a>
													</div>
												</div>
											</div>
										</div>
										
										<div class="fbTimelineUFI uiCommentContainer">
											<div class="fbTimelineFeedbackHeader">
												<div class="clearfix fbTimelineFeedbackActions">
													<div class="clearfix">
														<div class="_4bl7 _4bl8"></div>
														<div class="_4bl9">
															<span class="UFIBlingBoxTimeline"><span data-reactid=".13"></span></span>
															<span class="UIActionLinks UIActionLinks_bottom">
																<a class="like_link" title="Like this item" href="javascript://">Like</a> · <a class="comment_link" title="Leave a comment" href="javascript://">Comment</a>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="fbBorderBottom"></div>
							</div>
						</div>
					</div>	
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
										
					<div class="livePreviewCanvas da-form-item" id="TwitterLivePreview" style="padding-top: 15px;">
						<a href="javascript://" style="color: #9bc035; display: block; margin-bottom: 10px;">Preview before you publish</a>
						<div class="livePreviewBar" style="display: none; width: 512px;">
							<div class="twitter_livepreview_box">
								<div class="Grid" style="display: block; font-size: 0; margin: 0; padding: 0; text-align: left;">
									<div class="Grid-cell u-size3of3" style="box-sizing: border-box; display: inline-block; font-size: 14px; margin: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
										<div class="StreamItem js-stream-item" style="position: relative;">
											<div class="ProfileTweet u-textBreak js-tweet js-stream-tweet js-actionable-tweet ProfileTweet--low" style="background-color: #fff; border: 1px solid #e1e8ed; box-sizing: border-box; line-height: 1.375em; padding: 13px 15px 15px; position: relative; word-wrap: break-word !important; margin-bottom: -1px;">
												<div class="ProfileTweet-header clearfix" style="color: #8899a6; margin: 0; transition: color 0.15s ease 0s; line-height: 1.375em;">
													<div class="ProfileTweet-authorDetails  clearfix" style="padding-bottom: 5px; line-height: 14px; padding-top: 2px; color: #8899a6;">
														<a href="/vbouttestaccoun" class="ProfileTweet-originalAuthorLink u-linkComplex js-nav js-user-profile-link" style="float: left; color: #0084b4; text-decoration: none !important;">
															<img style="border-radius: 4px; float: left; height: 24px; margin: 0 6px 0 0; width: 24px;" alt="" src="https://abs.twimg.com/sticky/default_profile_images/default_profile_1_normal.png" class="ProfileTweet-avatar js-action-profile-avatar">
															
															<span class="ProfileTweet-originalAuthor u-pullLeft u-textTruncate js-action-profile-name" style="overflow: hidden !important; text-overflow: ellipsis !important; white-space: nowrap !important; word-wrap: normal !important; display: block; float: left;">
																<b class="ProfileTweet-fullname u-linkComplex-target" style="color: #292f33; font-size: 14px; font-weight: bold;float: left;">Twitter Account Name</b>
																<span dir="ltr" class="ProfileTweet-screenname u-inlineBlock u-dir" style="color: #8899a6; font-size: 13px; display: inline-block !important; max-width: 100%;float: left;">
																	<span class="at">&nbsp;@&nbsp;</span>TwitterAccountName
																</span>
															</span>
														</a>

														<span style="float: left !important;" class="u-pullLeft">&nbsp;·&nbsp;</span>
														<span style="float: left !important;" class="u-pullLeft">
															<a style="color: #8899a6; display: inline-block; font-size: 13px; transition: color 0.15s ease 0s; white-space: nowrap;text-decoration: none;" title="2:06 PM - 15 Jun 2014" href="/vbouttestaccoun/status/478282536418680832" class="ProfileTweet-timestamp js-permalink js-nav js-tooltip">
																<span data-long-form="true" data-time="1402866417" class="js-short-timestamp ">Just Now</span>
															</a>		
														</span>
													</div>
												</div>

												<div class="ProfileTweet-contents" style="margin-left: 30px; margin-top: -5px;">
													<p style="font-size: 16px; font-weight: 400; line-height: 22px; color: #292f33; margin-bottom: 5px; white-space: pre-wrap;" dir="ltr" class="ProfileTweet-text js-tweet-text u-dir">Please insert a text to share...</p>
												</div>
												
												<div class="TwitterPhoto-media" style="display: none; background-color: #fff; border: 1px solid #e1e8ed; border-radius: 5px; box-sizing: border-box; max-height: 262px; overflow: hidden;text-align: center;">
													<a style="display: inline-block; outline: 0 none;cursor: zoom-in; font-size: 0; max-width: 100%;" href="javascript://" class="TwitterPhoto-link media-thumbnail twitter-timeline-link">
														<img lazyload="1" style="margin-top: -34.0px;max-width: 100%; vertical-align: middle;display: inline-block;" alt="Embedded image permalink" src="" class="TwitterPhoto-mediaSource">
													</a>
												</div>
												
												<div class="TwitterFakeButtons" style="background: url('https://www.vbout.com/images/twitter_sharelinks.png') no-repeat 0 0; height: 14px; margin-left: 30px; margin-top: 10px; position: relative;">
													<a style=" display: block; height: 16px; left: 0; position: absolute; top: 0; width: 16px;" href="javascript://"></a>
													<a style=" display: block; height: 16px; left: 53px; position: absolute; top: 0; width: 16px;" href="javascript://"></a>
													<a style=" display: block; height: 16px; left: 106px; position: absolute; top: 0; width: 16px;" href="javascript://"></a>
													<a style=" display: block; height: 16px; left: 156px; position: absolute; top: 0; width: 16px;" href="javascript://"></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
			
					<div class="livePreviewCanvas da-form-item" id="LinkedinLivePreview" style="padding-top: 15px;">
						<a href="javascript://" style="color: #9bc035; display: block; margin-bottom: 10px;">Preview before you publish</a>
						<div class="livePreviewBar" style="display: none; border-bottom: 1px solid #eee; border-top: 1px solid #eee; padding: 20px 0; width: 512px;">
							<div class="linkedin_livepreview_box">
								<img style="display: block; float: left; border-color: #eee #eee #eee -moz-use-text-color; border-image: none; border-style: solid solid solid none; border-width: 1px 1px 1px 0; margin-right: 15px; padding: 0;" src="https://static.licdn.com/scds/common/u/images/themes/katy/ghosts/connections/ghost_connections_65x65_v1.png" />
								
								<div class="feed-item linkedin_share">
									<div class="feed-body feed-uscp" style="margin-left: 20px; margin-right: 0; overflow: hidden;">
										<div class="feed-content" style="line-height: 17px; margin-right: 20px; margin-top: 0; padding: 0; font-size: 13px;">
											<div class="annotated-body" style="display: inline;">
												<strong style="color: #333; font-size: 12px; font-weight: bold; line-height: 14px;"><a style="color: #0077b5; font-size: 13px; padding-top: 0;text-decoration:none;" href="javascript://">Linkedin Account Name</a></strong>
											</div>
											
											<div class="share-body" style="word-wrap: break-word;margin-top: 6px;">Please insert a text to share...</div>
											
											<div class="share-object linkedin-article" style="margin-right: 20px; margin-bottom: 0; margin-top: 8px;overflow: hidden;width: auto; display: none;">
												<a style="color: #0077b5; font-size: 13px; padding-top: 0; margin-right: 15px; float: left; overflow: hidden; text-decoration: none; display: none; max-width: 180px; position: relative; text-align: left; width: auto;" target="_blank" rel="nofollow" class="image " href="javascript://">
													<img width="180" height="110" alt="Difference between art and design" src="https://media.licdn.com/media-proxy/ext?w=180&amp;h=110&amp;f=c&amp;hash=28vYCp6orf7LMoPmAD3M1D%2FcWDE%3D&amp;ora=1%2CaFBCTXdkRmpGL2lvQUFBPQ%2CxAVta9Er0Ua9hFUMwBM09OCCokL_8VdLSoPYES_hAnbF_NeFaHToeMTce6zh-go">
												</a>
												
												<div class="properties" style="overflow: hidden;">
													<div class="share-title" style="color: #000; font-size: 14px; font-weight: normal; line-height: 17px; font-family: Arial,sans-serif; display: none;">
														<a style="margin-bottom: 7px; display: block; color: #000; font-size: 14px; font-weight: bold; line-height: 14px; text-decoration: none;" data-contentpermalink="http://www.siteforbiz.com" target="_blank" rel="nofollow" class="title" href="javascript://">Difference between art and design</a>
													</div>
													
													<a style="display: none; color: #999; float: left; font-size: 13px; font-weight: bold; line-height: 14px; margin-top: 1px; text-decoration: none; vertical-align: middle;" class="share-link" rel="nofollow" target="_blank" href="javascript://">siteforbiz.com</a>
													<span class="u-pullLeft" style="float: left; padding-left: 6px; padding-right: 6px;"> · </span>
													
													<p class="share-desc" style="color: #666; font-size: 13px; font-weight: normal; line-height: 17px;">
														<span class="description" style="color: #333;"></span>
													</p>
												</div>
											</div>
										</div>
										
										<div class="feed-item-meta" style="border: 0 none; clear: left; margin: 7px 0 0; padding: 0;">
											<ul class="feed-actions" style="overflow: hidden;">
												<li class="feed-like" style="font-size: 13px; margin: 0 0 0 0; padding: 0 0 0 0; display: block; float: left;">
													<span class="show-like">
														<a role="button" class="unlike" href="javascript://" style="text-decoration:none;">Like </a>
														<span class="u-pullLeft" style="display: inline-block; padding-left: 10px; padding-right: 10px;"> · </span>
													</span>
												</li>
												
												<li class="feed-comment" style="font-size: 13px; margin: 0 0 0 0; padding: 0 0 0 0; display: block; float: left;">
													<a role="button" data-li-trk-code="feed-comment" data-li-num-commented="0" title="Click to comment on this update" class="focus-comment-form" href="javascript://" style="text-decoration:none;">Comment </a>
													<span class="u-pullLeft" style="display: inline-block; padding-left: 10px; padding-right: 10px;"> · </span>
												</li>
												
												<li class="feed-share" style="font-size: 13px; margin: 0 0 0 0; padding: 0 0 0 0; display: block; float: left;">
													<a style="text-decoration:none;" role="button" data-li-trk-code="feed-share" title="Share" href="#" id="control_gen_5">Share</a>
													<span class="u-pullLeft" style="display: inline-block; padding-left: 10px; padding-right: 10px;"> · </span>
												</li>
												
												<li class="feed-share" style="font-size: 13px; margin: 0 0 0 0; padding: 0 0 0 0; display: block; float: left;">
													<a class="nus-timestamp" style="text-decoration:none;color: #8b8b8b; font-size: 13px; margin-left: 0; padding-right: 14px;" href="javascript://">Just Now</a>
												</li>
											</ul>									
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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