<?php
namespace EventRegistration;

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Event_Registration
 * @subpackage Event_Registration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the event registration, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Event_Registration
 * @subpackage Event_Registration/admin
 * @author     Your Name <email@example.com>
 */
class Event_Registration_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $event_registration    The ID of this plugin.
	 */
	private $event_registration;

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
	 * @param      string    $event_registration       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $event_registration, $version ) {

		$this->event_registration = $event_registration;
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
		 * defined in Event_Registration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_Registration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->event_registration, plugin_dir_url( __FILE__ ) . 'css/event-registration-admin.css', array(), $this->version, 'all' );
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
		 * defined in Event_Registration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_Registration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script( $this->event_registration, plugin_dir_url( __FILE__ ) . 'js/event-registration-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_menu_page() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Event_Registration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_Registration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		add_menu_page(
			'eventssw',
			'events',
			'read',
			'event',
			['EventRegistration\Event_Registration_Admin_Display_Event_List' , 'render']
		);

	}

	public static function render()
	{
		echo 'jaja';
	}

}
