<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpcontentcalendar.com
 * @since      1.0.0
 *
 * @package    Wp_Content_Calendar-Lite
 * @subpackage Wp_Content_Calendar-Lite/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="calendar_wrapper">
	<div class="top-title"><h1>Posts Calendar</h1></div>	
	<div id='calendar'></div>
	<div id="s_u_box">
		<div class="wpcc_upsell"><a href="https://wpcontentcalendar.com">Upgrade to PRO for "What To Write" Calendar Generator</a></div>
        <div id="un-main">        	
            <div class="head-un-main" title="Unscheduled draft posts"><div class="head-1-um"><span>Unscheduled Drafts</span></div></div>
            <div class="head-un-area" id="">
                <div style="display: none;"></div>
                <div id='external-events'>
					<?php $args = array(
					'orderby'          => 'date',
					'order'            => 'DESC',
					'post_type'        => 'post',
					'post_status'      => 'draft',
					'suppress_filters' => true 
				);
				$posts_array = get_posts( $args ); 
				foreach ($posts_array as $wpcc_post)
				{
					$timestamp = strtotime($wpcc_post->post_date);
					
					?>
					<div id="wpcc_event_<?php echo $wpcc_post->ID; ?>" class='fc-event'><?php echo '<b>'.date('H:i', $timestamp).'</b> '.$wpcc_post->post_title; ?></div>
					<?php
				}
				?>
				</div>                        
            </div>
        </div>
	</div>
</div>
	