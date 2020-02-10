<?php
namespace EventRegistration\Event\Queries;

if (! defined('WPINC')) {
    die;
}

class ListEventQuery
{
    private $wpdb;

    public function __construct (\wpdb $wpdb = null)
    {
        $this->wpdb = $wpdb;
    }

    public function GetEventList() : array
    {
        $results = $this->wpdb->get_results("
            SELECT
                id,
                title,
                slug,
                startRegistrationDate,
                eventDate,
                price,
                slots,
                eventType
            FROM {$this->wpdb->prefix}er_events
            WHERE archived = 0
        ;", ARRAY_A);

        return $results;
    }
}
