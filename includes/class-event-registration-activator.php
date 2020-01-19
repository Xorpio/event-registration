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
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $table_name = $wpdb->prefix . 'er_events';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$wpdb->prefix}er_events (
            `title` varchar(50) NOT NULL,
            `slots` int(11) NOT NULL,
            `startRegistrationDate` date NOT NULL,
            `endRegistrationDate` date DEFAULT NULL,
            `eventDate` date NOT NULL,
            `eventType` varchar(45) NOT NULL,
            `archived` bit(1) DEFAULT b'0',
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `price` decimal(5,2) NOT NULL,
            `tax` int(11) NOT NULL,
            PRIMARY KEY  (`id`)
        ) $charset_collate;";
        dbDelta( $sql );

        $sql = "CREATE TABLE {$wpdb->prefix}er_payment (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `registrationId` int(11) NOT NULL,
            `price` decimal(5,2) NOT NULL,
            `tax` int(11) NOT NULL,
            PRIMARY KEY  (`id`)
        ) $charset_collate;";
        dbDelta( $sql );

        $sql = "CREATE TABLE {$wpdb->prefix}er_registration (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `state` varchar(45) NOT NULL,
            `eventId` int(11) NOT NULL,
            `registrationDate` datetime NOT NULL,
            `initials` varchar(20) NOT NULL,
            `lastName` varchar(100) NOT NULL,
            `surName` varchar(10) DEFAULT NULL,
            PRIMARY KEY  (`id`)
        ) $charset_collate;";
        dbDelta( $sql );

        $sql = "CREATE TABLE {$wpdb->prefix}er_runner (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `initials` varchar(10) NOT NULL,
            `lastName` varchar(100) NOT NULL,
            `surName` varchar(20) DEFAULT NULL,
            `documentNr` varchar(45) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            `registrationId` int(11) NOT NULL,
            PRIMARY KEY  (`id`)
        ) $charset_collate;";
        dbDelta( $sql );

        $sql = "CREATE TABLE {$wpdb->prefix}er_team (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(45) NOT NULL,
            `registrationId` int(11) NOT NULL,
            PRIMARY KEY  (`id`)
        ) $charset_collate;";
        dbDelta( $sql );

        add_option( 'event_reg_db_version', EVENT_REGISTRATION_VERSION );
    }

}
