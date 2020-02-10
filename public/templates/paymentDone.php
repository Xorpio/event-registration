<?php

use EventRegistration\Payment\Commands\CreatePaymentCommand;
use EventRegistration\Payment\Commands\EventNotFoundResult;
use EventRegistration\Payment\Commands\CreatePaymentEventResultSucces;
use EventRegistration\Payment\PaymentCommandHandler;

$cmd = new CreatePaymentCommand(get_query_var('eventtitle'));
global $wpdb;
$handler = new PaymentCommandHandler($wpdb);

if ($_POST)
{
    $cmd->SetPost($_POST);
}

$response = $handler->HandeCreateEvent($cmd);

get_header(); ?>
        <div id="primary">
            <div id="content" role="main">
                <div class="container-fluid">
                    <h1>jaja</h1>
                </div>
            </div><!-- #content -->
        </div><!-- #primary -->
<?php get_footer(); ?>
