<?php
namespace EventRegistration\Options;

use EventRegistration\Options\Commands\CreateOptionsCommand;
use EventRegistration\Options\Commands\CreateOptionsResult;
use Valitron\Validator;

if (! defined('WPINC')) {
    die;
}

class OptionsCommandHandler
{
    public function HandleEvent(CreateOptionsCommand $cmd): CreateOptionsResult
    {
        $validator = new Validator($cmd->ToArray(), [], 'nl');
        $validator
            ->rule('lengthMax', 'mollieApiKey', 50)->label('Mollie API key')
            ;

        if (!$validator->validate()) {
            return new CreateOptionsResult(false, $validator->errors());
        }

        update_option('er_mollieApiKey', $cmd->GetMollieApiKey());

        return new CreateOptionsResult(true);
    }
}
