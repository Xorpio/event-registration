<?php
namespace EventRegistration\Event\Queries;

if (! defined('WPINC')) {
    die;
}

class ListEventQuery
{
    public function GetEventList() : array
    {
        // @var \wpdb $wpdb
        global $wpdb;

        $results = $wpdb->get_results("
            SELECT
                id,
                title
            FROM {$wpdb->prefix}er_events
            WHERE archived = 0
        ;", ARRAY_A);

        return $results;
    }
}
