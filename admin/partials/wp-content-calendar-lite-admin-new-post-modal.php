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
<div id="new_post_this_modal" class="modal this_modal">
	<?php //print_r($wpcc_post_cc_obj); ?>

<div id="">
<h3 id="">Add Post - <?php echo $wpcc_new_post_date; ?></h3>
</div>

<div class="inline-edit-row">
<form id="wpcc_new_box_form_1" class="wpcc_new_box_form">
	<fieldset>

    <label>
        <span class="title">Title</span>
        <span class="input-text-wrap"><input class="ptitle" id="" name="title" type="text" placeholder="Write your title here" value=""></span>
    </label>

    <div id="">
        <label>
            <span class="title">Time</span>
            <span class="input-text-wrap">
            	<input class="ptitle wpcc_new_box_time time" id="" name="time" type="text" value="<?php echo date('H:i'); ?>">
            </span>
        </label>
            
        <label>
            <span class="title">Status</span>
            <span class="input-text-wrap">
                <select name="status" id="wpcc_postselect">
                    <option selected value="draft">Draft</option>
                    <option value="pending">Pending Review</option>
                    <option value="future">Scheduled</option>
                    <option value="publish">Published</option>
            </select>
            </span>
        </label>
    </div>

    </fieldset>   
	<input id="" name="wpcc_newdate" value="<?php echo $wpcc_new_post_date; ?>" type="hidden">
    <p class="submit wpcc_new_buttons" id="">
        <a href="#" rel="modal:close" class="button-secondary cancel">Cancel</a>
        <input class="button-primary wpcc_new_box_post_button" id="" type="submit" value="Add">        
    </p>
</form>
    
<script>
    jQuery(function($) {
        $('.wpcc_new_box_time').timepicker({ 'scrollDefault': 'now' });
    });
</script>
</div>                
                
</div>