<?php
namespace EventRegistration;

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Event_Registration
 * @subpackage Event_Registration/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Event_Registration
 * @subpackage Event_Registration/includes
 * @author     Your Name <email@example.com>
 */
class Event_Registration_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        self::tableCreate();
    }

    private static function tableCreate() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'er_events';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id int NOT NULL AUTO_INCREMENT,
            title varchar(50) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        add_option( 'event_reg_db_version', EVENT_REGISTRATION_VERSION );
    }

}
