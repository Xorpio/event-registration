<?php


namespace EventRegistration;

use EventRegistration\partials\PublicDisplay;


if ( ! defined( 'WPINC' ) ) { die; }


/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Event_Registration
 * @subpackage Event_Registration/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the event registration, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Event_Registration
 * @subpackage Event_Registration/public
 * @author     Your Name <email@example.com>
 */
class Event_Registration_Public {

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
     * @param      string    $event_registration       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $event_registration, $version ) {

        $this->event_registration = $event_registration;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style( $this->event_registration, plugin_dir_url( __FILE__ ) . 'css/event-registration-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->event_registration, plugin_dir_url( __FILE__ ) . 'css/event-registration-public.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script( $this->event_registration, plugin_dir_url( __FILE__ ) . 'js/event-registration-public.js', array( 'jquery' ), $this->version, false );

    }

    public function register_shortcodes() {
        add_shortcode('er_signup', [$this, 'display']);
    }

    public function event_page_template($template)
    {
        $controller = new PublicDisplay();

        if (is_page('event')) {

            if (get_query_var('payment') != '') {
                $themeTemplate = get_theme_file_path('paymentDone.php');
                if(is_file($themeTemplate)) {
                    return $themeTemplate;
                }

                $new_template = plugin_dir_path(__FILE__) . 'templates/paymentDone.php';
                if (is_file($new_template)) {
                    return $new_template;
                }
            } else {
                $themeTemplate = get_theme_file_path('eventForm.php');
                if(is_file($themeTemplate)) {
                    return $themeTemplate;
                }

                $new_template = plugin_dir_path(__FILE__) . 'templates/eventForm.php';
                if (is_file($new_template)) {
                    return $new_template;
                }
            }
        }

        return $template;
    }

    function add_rewrite_rules( $wp_rewrite )
    {
        $new_rules = array
        (
            '(payment)/success/(.*?)/?$' =>
                'index.php?pagename=event'.
                '&payment='.$wp_rewrite->preg_index(2),

            '(event)/(.*?)/?$' =>
                'index.php?pagename='.$wp_rewrite->preg_index(1).
                '&eventtitle='.$wp_rewrite->preg_index(2),
        );
        // Always add your rules to the top, to make sure your rules have priority
        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    }

    function query_vars($public_query_vars)
    {
        $public_query_vars[] = "eventtitle";
        $public_query_vars[] = "payment";
        return $public_query_vars;
    }

    function flush_rewrite_rules()
    {
        global $wp_rewrite;

        $wp_rewrite->flush_rules();
    }


}
