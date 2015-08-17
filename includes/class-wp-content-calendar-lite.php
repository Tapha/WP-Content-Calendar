<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wpcontentcalendar.com
 * @since      1.0.0
 *
 * @package    WP_Content_Calendar_Lite
 * @subpackage WP_Content_Calendar_Lite/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP_Content_Calendar_Lite
 * @subpackage WP_Content_Calendar_Lite/includes
 * @author     Tapha Ngum <tapha@taphamedia.com>
 */
class WP_Content_Calendar_Lite {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_Content_Calendar_Lite_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-content-calendar-lite';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_Content_Calendar_Lite_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Content_Calendar_Lite_i18n. Defines internationalization functionality.
	 * - WP_Content_Calendar_Lite_Admin. Defines all hooks for the admin area.
	 * - WP_Content_Calendar_Lite_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-content-calendar-lite-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-content-calendar-lite-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-content-calendar-lite-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-content-calendar-lite-public.php';

		$this->loader = new WP_Content_Calendar_Lite_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_Content_Calendar_Lite_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WP_Content_Calendar_Lite_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WP_Content_Calendar_Lite_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wp_content_calendar_lite_create_main_menu' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wp_content_calendar_lite_create_posts_menu' );
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_get_all_posts', $plugin_admin, 'wpcontentcalendar_lite_get_all_posts' );
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_add_post_date', $plugin_admin, 'wpcontentcalendar_lite_add_post_date' );
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_update_post_date', $plugin_admin, 'wpcontentcalendar_lite_update_post_date' );
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_get_post_data_for_edit', $plugin_admin, 'wpcontentcalendar_lite_get_post_data_for_edit' );
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_submit_post_data_for_edit', $plugin_admin, 'wpcontentcalendar_lite_submit_post_data_for_edit' );
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_new_post_from_click', $plugin_admin, 'wpcontentcalendar_lite_new_post_from_click' );	
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_submit_post_data_for_post', $plugin_admin, 'wpcontentcalendar_lite_submit_post_data_for_post' );			
		$this->loader->add_action( 'wp_ajax_wpcontentcalendar_lite_delete_post', $plugin_admin, 'wpcontentcalendar_lite_delete_post' );
				
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WP_Content_Calendar_Lite_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WP_Content_Calendar_Lite_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
