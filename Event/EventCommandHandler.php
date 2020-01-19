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
            ;
        if (!$validator->validate()) {
            return new CreateEventResult(false, $validator->errors());
        }

        return new CreateEventResult(true);
    }
}
