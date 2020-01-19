<?php
namespace EventRegistration;

if ( ! defined( 'WPINC' ) ) { die; }


/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Event_Registration
 * @subpackage Event_Registration/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Event_Registration
 * @subpackage Event_Registration/includes
 * @author     Your Name <email@example.com>
 */
class Event_Registration_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        self::deleteTable();
    }

    private static function deleteTable() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'er_events';
        $wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

        delete_option("event_reg_db_version");
    }

}
