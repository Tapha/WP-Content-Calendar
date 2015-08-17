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
<div id="this_modal" class="modal this_modal">
	<?php //print_r($wpcc_post_cc_obj); ?>

<div id="">
<h3 id="">Edit Post - <?php echo $wpcc_post_cc_obj->post_title; ?></h3>
</div>

<div class="inline-edit-row">
<form class="wpcc_edit_box_form">
	<fieldset>

    <label>
        <span class="title">Title</span>
        <span class="input-text-wrap"><input class="ptitle" id="" name="title" type="text" value="<?php echo $wpcc_post_cc_obj->post_title; ?>"></span>
    </label>

    <label>
        <span class="title">Slug</span>
        <span class="input-text-wrap"><input class="ptitle" id="" name="slug" type="text" value="<?php echo $wpcc_post_cc_obj->post_name; ?>"></span>
    </label>

    <div id="">
        <label>
            <span class="title">Time</span>
            <span class="input-text-wrap">
            	<input class="ptitle wpcc_edit_box_time time" id="" name="time" type="text" value="<?php echo date('H:i', strtotime($wpcc_post_cc_obj->post_date)); ?>" data-scroll-default="<?php echo date('H:i', strtotime($wpcc_post_cc_obj->post_date)); ?>">
            </span>
        </label>
            
        <label>
            <span class="title">Status</span>
            <span class="input-text-wrap">
                <select name="status" id="wpcc_editselect">
                    <option <?php echo $wpcc_selected = ($wpcc_post_cc_obj->post_status == 'draft' ? 'selected' : ''); ?> value="draft">Draft</option>
                    <option <?php echo $wpcc_selected = ($wpcc_post_cc_obj->post_status == 'pending' ? 'selected' : ''); ?> value="pending">Pending Review</option>
                    <option <?php echo $wpcc_selected = ($wpcc_post_cc_obj->post_status == 'future' ? 'selected' : ''); ?> value="future">Scheduled</option>
                    <option <?php echo $wpcc_selected = ($wpcc_post_cc_obj->post_status == 'publish' ? 'selected' : ''); ?> value="publish">Published</option>
            </select>
            </span>
        </label>
    </div>

        </fieldset>   
	<?php 
		$wpcc_edit_date_timestamp = strtotime($wpcc_post_cc_obj->post_date);
		$wpcc_date_curr = date('Y-m-d', $wpcc_edit_date_timestamp);
	?>
	<input id="" name="wpcc_editdate" value="<?php echo $wpcc_date_curr; ?>" type="hidden">
    <input id="" name="wpcc_editid" value="<?php echo $wpcc_post_cc_obj->ID; ?>" type="hidden">
    <p class="submit wpcc_edit_buttons" id="">
        <a href="#" rel="modal:close" class="button-secondary cancel">Cancel</a>
        <input class="button-primary wpcc_edit_box_save_button" id="" type="submit" value="Save">        
    </p>
</form>
    
<script>
    jQuery(function($) {
        $('.wpcc_edit_box_time').timepicker();
    });
</script>
</div>                
                
</div>