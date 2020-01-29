<?php
namespace EventRegistration\Event;

use EventRegistration\Event\Commands\CreateEventCommand;
use EventRegistration\Event\Commands\CreateEventResult;
use Valitron\Validator;

if (! defined('WPINC')) {
    die;
}

class EventCommandHandler
{
    private $wpdb;

    public function __construct(\wpdb $wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function HandeCreateEvent(CreateEventCommand $cmd): CreateEventResult
    {
        $validator = new Validator($cmd->ToArray(), [], 'nl');
        $validator
            ->rule('required', 'title')->label('Titel')
            ->rule('lengthMax', 'title', 50)->label('Titel')
            ->rule(function($field, $value, $params, $fields) {
                $sum = $this->wpdb->get_var( $this->wpdb->prepare( "
                    SELECT
                        COUNT(*)
                    FROM {$this->wpdb->prefix}er_events
                    WHERE archived = 0
                        AND title = %s"
                    , $value ) );

                return $sum == 0;
            }, 'title')->message('Titel moet een unieke waarde zijn')

            ->rule('required', 'slots')->label('Plaatsen')
            ->rule('min', 'slots', 1)->label('Plaatsen')

            ->rule(function($field, $value, $params, $fields) {
                return $value < $fields['eventDate'];
            }, 'startRegistrationDate')->message('Start inschrijving moet voor het evenement datum liggen')

            ->rule('required', 'eventDate')->label('Einde inschrijving')
            ->rule(function($field, $value, $params, $fields) {
                return $value < $fields['eventDate'];
            }, 'endRegistrationDate')->message('Einde inschrijving moet na de start inschrijving datum liggen')

            ->rule('required', 'eventDate')->label('Event datum')

            ->rule('required', 'eventType')->label('Event type')
            ->rule('in', 'eventType', ['run','dartdrive'])->label('Event type')

            ->rule('required', 'price')->label('Prijs')
            ->rule('min', 'price', 0)->label('Prijs')

            ->rule('required', 'tax')->label('BTW')
            ->rule('min', 'tax', 0)->label('BTW')
            ->rule('max', 'tax', 100)->label('BTW')
            ;

        if (!$validator->validate()) {
            return new CreateEventResult(false, $validator->errors());
        }

        $table = $this->wpdb->prefix.'er_events';
        $data = [
            'title' => $cmd->GetTitle(),
            'slug' => sanitize_title($cmd->GetTitle()),
            'slots' => $cmd->GetSlots(),
            'startRegistrationDate' => $cmd->GetStartRegistrationDate()->format('Y-m-d'),
            'endRegistrationDate' => $cmd->GetEndRegistrationDate()->format('Y-m-d'),
            'eventDate' => $cmd->GetEventDate()->format('Y-m-d'),
            'eventType' => $cmd->GetEventType(),
            'price' => $cmd->GetPrice(),
            'tax' => $cmd->GetTax()
        ];
        $format = [
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%f',
            '%d'
        ];
        $this->wpdb->insert($table,$data,$format);
        $my_id = $this->wpdb->insert_id;

        return new CreateEventResult(true);
    }
}
