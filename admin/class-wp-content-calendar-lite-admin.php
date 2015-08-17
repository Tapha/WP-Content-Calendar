<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpcontentcalendar_lite.com
 * @since      1.0.0
 *
 * @package    Wp_Content_Calendar-Lite
 * @subpackage Wp_Content_Calendar-Lite/admin
 * @author     Tapha Ngum <tapha@taphamedia.com>
 */
class Wp_Content_Calendar_Lite_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wp_content_calendar_lite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wp_content_calendar_lite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'_fullcalendar_css', plugin_dir_url( __FILE__ ) . 'css/fullcalendar.min.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name.'_jquery_modal_css', plugin_dir_url( __FILE__ ) . 'css/jquery.modal.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name.'_jquery_timepicker_css', plugin_dir_url( __FILE__ ) . 'css/jquery.timepicker.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-content-calendar-lite-admin.css', array(), $this->version, 'all' );		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wp_content_calendar_lite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wp_content_calendar_lite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script('jquery-ui-core');
		
		wp_enqueue_script('jquery-ui-draggable');
		
		wp_enqueue_script( $this->plugin_name.'_momentjs', plugin_dir_url( __FILE__ ) . 'js/lib/moment.min.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'_fullcalendar_js', plugin_dir_url( __FILE__ ) . 'js/fullcalendar.min.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'_jquery_modal_min_js', plugin_dir_url( __FILE__ ) . 'js/jquery.modal.min.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'_jquery_timepicker_min_js', plugin_dir_url( __FILE__ ) . 'js/jquery.timepicker.min.js', array( 'jquery' ), $this->version, false );				
				
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-content-calendar-lite-admin.js', array( 'jquery' ), $this->version, true );
		
		wp_localize_script($this->plugin_name, 'WPURLS', array( 'siteurl' => get_option('siteurl') ));
	}
	
	public function wp_content_calendar_lite_create_main_menu() {
		$page_title = 'WP Content Calendar';
		$menu_title = 'WP Content Calendar';
		$capability = 'edit_pages';
		$menu_slug 	= 'wp-content-calendar-lite';
		$function 	= array($this, 'show_wp_content_calendar_lite_page');
		$icon_url 	= 'dashicons-calendar-alt';
		$position 	= 71;
		
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		
		//Add first main calendar page
		add_submenu_page( $menu_slug, 'Calendar', 'Calendar', 'manage_options', $menu_slug, array($this, 'show_wp_content_calendar_lite_page') );
		//Add second calendar settings page
		add_submenu_page( $menu_slug, 'Upgrade', 'Upgrade To Pro', 'manage_options', 'wp-content-calendar-lite-upgrade', array($this, 'show_wp_content_calendar_lite_page_upgrade'), 'dashicons dashicons-external' );
	}
	
	public function wp_content_calendar_lite_create_posts_menu() {
		$wpcc_posts_page_title = 'WP Content Calendar';
		$wpcc_posts_menu_title = 'Calendar';
		$wpcc_posts_capability = 'edit_pages';
		$wpcc_posts_menu_slug = 'wp-content-calendar-lite-posts';;
		$wpcc_posts_function = array($this, 'show_wp_content_calendar_lite_post_page');;
		
		add_posts_page( $wpcc_posts_page_title, $wpcc_posts_menu_title, $wpcc_posts_capability, $wpcc_posts_menu_slug, $wpcc_posts_function);
	} 

	public function show_wp_content_calendar_lite_page() {
		require_once('partials/wp-content-calendar-lite-admin-display.php');
	}
	
	public function show_wp_content_calendar_lite_page_upgrade() {
		echo '<script type="text/javascript">
           		window.location = "https://wpcontentcalendar.com/"
      		  </script>';
	}
	
	public function show_wp_content_calendar_lite_post_page() {
		require_once('partials/wp-content-calendar-lite-admin-display-post.php');
	}
	
	public function wpcontentcalendar_lite_get_all_posts() {
		$args = array(
			'posts_per_page'   => 30,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'post',
			'post_status'      => 'any',
			'suppress_filters' => true 
		);
		$posts_array = get_posts( $args );
		echo json_encode( $posts_array );
	}
	
	public function wpcontentcalendar_lite_add_post_date() {
		  $new_date = $_POST['wpcc_post_date'];    
		  $new_date_timestamp = strtotime($new_date);
		  $wpcc_gmt_date_curr = date('Y-m-d H:i:s', $new_date_timestamp);
		  $wpcc_gmt_date = get_gmt_from_date( $wpcc_gmt_date_curr );
		  // add post 
		  $my_post = array(
		      'ID'          => $_POST['wpcc_post_id'],
		      'post_date'   => $wpcc_gmt_date_curr,
		      'post_date_gmt' => $wpcc_gmt_date,
		      'post_status' => 'future',
		      'edit_date' 	=> true,
		  );
		
		  // Update the post into the database
		  $res = wp_update_post( $my_post );
		  echo $res;
	}
	
	public function wpcontentcalendar_lite_update_post_date() {
		  $new_date = $_POST['wpcc_post_date'];
		  $new_date_timestamp = strtotime($new_date);
		  $wpcc_gmt_date_curr = date('Y-m-d H:i:s', $new_date_timestamp);
		  $wpcc_gmt_date = get_gmt_from_date( $wpcc_gmt_date_curr );
		  // Update post 
		  $my_post = array(
		      'ID'          => $_POST['wpcc_post_id'],
		      'post_date'   => $wpcc_gmt_date_curr,
		      'post_date_gmt' => $wpcc_gmt_date,		      
		      'edit_date' 	=> true,
		  );
		
		  // Update the post into the database
		  $res = wp_update_post( $my_post );
		  
		  echo $res;
	}
	
	public function wpcontentcalendar_lite_get_post_data_for_edit() {
		$wpcc_current_post_id = intval($_POST['wpcc_post_id_for_edit']);
		echo $wpcc_current_post_id;
		$wpcc_post_cc_obj = get_post( $wpcc_current_post_id );
		require_once('partials/wp-content-calendar-lite-admin-edit-post-modal.php');
	}
	
	public function wpcontentcalendar_lite_new_post_from_click() {
		$wpcc_new_post_date = $_POST['wpcc_post_date'];		
		require_once('partials/wp-content-calendar-lite-admin-new-post-modal.php');
	}
	
	public function wpcontentcalendar_lite_submit_post_data_for_post() {
		$wpcc_post_edit_date = $_POST['wpcc_post_date_for_post_submit'];
        $wpcc_post_edit_title = $_POST['wpcc_post_title_for_post_submit'];
        $wpcc_post_edit_time = $_POST['wpcc_post_time_for_post_submit'];
        $wpcc_post_edit_status = $_POST['wpcc_post_status_for_post_submit'];
        
        $wpcc_post_edit_time = date('H:i', strtotime($wpcc_post_edit_time));
        
        //Get new time
        $combinedDT = date('Y-m-d H:i:s', strtotime("$wpcc_post_post_date $wpcc_post_post_time"));
        
        //Get gmt time
        $combinedwpcc_gmt_date = get_gmt_from_date( $combinedDT );
        
        
        // Create post 
		$new_wmy_post = array(
		      'post_title'  => $wpcc_post_edit_title,
		      'post_date'   => $combinedDT,
		      'post_date_gmt' => $combinedwpcc_gmt_date,
		      'post_status' => $wpcc_post_edit_status
		);
		
		// Update the post into the database
		$res = wp_insert_post( $new_wmy_post );
		echo $res;
	}		
	
	public function wpcontentcalendar_lite_submit_post_data_for_edit() {
		$wpcc_post_edit_id = intval($_POST['wpcc_post_id_for_edit_submit']);
		$wpcc_post_edit_date = $_POST['wpcc_post_date_for_edit_submit'];
        $wpcc_post_edit_title = $_POST['wpcc_post_title_for_edit_submit'];
        $wpcc_post_edit_slug = $_POST['wpcc_post_slug_for_edit_submit'];
        $wpcc_post_edit_time = $_POST['wpcc_post_time_for_edit_submit'];
        $wpcc_post_edit_status = $_POST['wpcc_post_status_for_edit_submit'];
        
        $wpcc_post_edit_time = date('H:i', strtotime($wpcc_post_edit_time));
        
        //Get new time
        $combinedDT = date('Y-m-d H:i:s', strtotime("$wpcc_post_edit_date $wpcc_post_edit_time"));
        
        //Get gmt time
        $combinedwpcc_gmt_date = get_gmt_from_date( $combinedDT );
        
        
        // Update post 
		$wmy_post = array(
		      'ID'          => $wpcc_post_edit_id,
		      'post_title'  => $wpcc_post_edit_title,
		      'post_name'   => $wpcc_post_edit_slug,
		      'post_date'   => $combinedDT,
		      'post_date_gmt' => $combinedwpcc_gmt_date,
		      'post_status' => $wpcc_post_edit_status,		      
		      'edit_date' 	=> true
		);
		
		// Update the post into the database
		$res = wp_update_post( $wmy_post );
		echo $res;
	}
	
	public function wpcontentcalendar_lite_delete_post() {
		$delete_post_id = $_POST['wpcc_delete_post_id'];
		$res = wp_delete_post( $delete_post_id );
		echo $res;
	}
		
}
