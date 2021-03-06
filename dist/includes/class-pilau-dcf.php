<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Pilau_DCF
 * @subpackage Pilau_DCF/includes
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
 * @package    Pilau_DCF
 * @subpackage Pilau_DCF/includes
 * @author     Steve Taylor <steve@sltaylor.co.uk>
 */
class Pilau_DCF {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pilau_DCF_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * The title of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_title    The title of this plugin.
	 */
	protected $plugin_title;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The prefix for meta keys
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $prefix    The prefix for meta keys
	 */
	private $prefix;

	/**
	 * The boxes of custom fields
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array	    $version    The boxes of custom fields
	 */
	protected $boxes;

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

		$this->plugin_name		= 'pilau-dcf';
		$this->version			= '1.0.0';
		$this->title			= "Pilau Developer's Custom Fields";
		$this->prefix			= '_pdcf_';
		$this->boxes			= array();

		/*
		$slt_custom_fields = array();
		$slt_custom_fields['prefix'] = '_slt_';
		$slt_custom_fields['hide_default_custom_meta_box'] = true;
		$slt_custom_fields['datepicker_default_format'] = 'dd/mm/yy';
		$slt_custom_fields['timepicker_default_format'] = 'hh:mm';
		$slt_custom_fields['timepicker_default_ampm'] = false;
		$slt_custom_fields['query_vars'] = array();

// Constants that can be overridden in wp-config.php
		if ( ! defined( 'SLT_CF_USE_GMAPS' ) ) {
			define( 'SLT_CF_USE_GMAPS', true );
		}
		if ( ! defined( 'SLT_CF_USE_FILE_SELECT' ) ) {
			define( 'SLT_CF_USE_FILE_SELECT', true );
		}
		if ( ! defined( 'SLT_CF_HANDLE_TERM_SPLITTING' ) ) {
			define( 'SLT_CF_HANDLE_TERM_SPLITTING', false );
		}
*/

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
	 * - Pilau_DCF_Loader. Orchestrates the hooks of the plugin.
	 * - Pilau_DCF_i18n. Defines internationalization functionality.
	 * - Pilau_DCF_Admin. Defines all hooks for the admin area.
	 * - Pilau_DCF_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pilau-dcf-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pilau-dcf-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pilau-dcf-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pilau-dcf-public.php';

		/**
		 * The class responsible for defining boxes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pilau-dcf-box.php';

		/**
		 * The class responsible for defining fields
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pilau-dcf-field.php';

		$this->loader = new Pilau_DCF_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pilau_DCF_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Pilau_DCF_i18n();
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

		$plugin_admin = new Pilau_DCF_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Pilau_DCF_Public( $this->get_plugin_name(), $this->get_version() );

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
	 * @return    Pilau_DCF_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Register a box
	 *
	 * @since	1.0.0
	 * @param	array	$box	Details of the box, including an array of its fields
	 * @return	void
	 */
	public function register_box( $box ) {
		$this->boxes[] = new Pilau_DCF_Box( $box );
	}

}
