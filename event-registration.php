<?php
namespace EventRegistration {

require __DIR__ . '/vendor/autoload.php';

use EventRegistration\Event_Registration_Activator;
use EventRegistration\Event_Registration_Deactivator ;
use EventRegistration\Event_Registration;

    if ( ! defined( 'WPINC' ) ) { die; }


    /**
     * The plugin bootstrap file
     *
     * This file is read by WordPress to generate the plugin information in the plugin
     * admin area. This file also includes all of the dependencies used by the plugin,
     * registers the activation and deactivation functions, and defines a function
     * that starts the plugin.
     *
     * @link              http://example.com
     * @since             1.0.0
     * @package           Event_Registration
     *
     * @wordpress-plugin
     * Plugin Name:       Event Registration
     * Plugin URI:        http://example.com/event-registration-uri/
     * Description:       Team 77 event registration
     * Version:           1.0.0
     * Author:            Niek
     * Author URI:        https://team77midden-brabant.nl
     * License:           GPL-2.0+
     * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain:       event-registration
     * Domain Path:       /languages
     */

    // If this file is called directly, abort.
    if ( ! defined( 'WPINC' ) ) {
        die;
    }

    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define( 'EVENT_REGISTRATION_VERSION', '1.0.0' );

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-event-registration-activator.php
     */
    function activate_event_registration() {
        Event_Registration_Activator::activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-event-registration-deactivator.php
     */
    function deactivate_event_registration() {
        Event_Registration_Deactivator::deactivate();
    }

    register_activation_hook( __FILE__, 'EventRegistration\activate_event_registration' );
    register_deactivation_hook( __FILE__, 'EventRegistration\deactivate_event_registration' );

    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-event-registration.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */

    function run_event_registration() {

        $plugin = new Event_Registration();
        $plugin->run();

    }
    run_event_registration();

}

namespace {
    function print_pre($object, $die = true, $vardump = true)
    {
        if (getenv('ENVIRONMENT') != 'dev')
            return;

        //add backtrace
        $bt = debug_backtrace();
        $backtrace = array_shift($bt);
        $date = new DateTime();

        //output first line
        echo "<b>print_pre ({$date->format('H:i:s')}) from {$backtrace["file"]} line: {$backtrace["line"]} </b><pre>";

        if ($vardump)
            var_dump($object);
        else
            print_r($object);

        echo "</pre>";

        if ($die)
            die;
    }
}
