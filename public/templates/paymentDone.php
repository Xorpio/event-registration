<?php

use EventRegistration\Payment\Commands\CreatePaymentCommand;
use EventRegistration\Payment\Commands\CreatePaymentEventResult;
use EventRegistration\Payment\Commands\PaymentNotFoundResult;
use EventRegistration\Payment\Commands\PaymentFailedResult;
use EventRegistration\Payment\PaymentCommandHandler;

$cmd = new CreatePaymentCommand(get_query_var('payment'));

global $wpdb;
$handler = new PaymentCommandHandler($wpdb);

$response = $handler->HandeCreateEvent($cmd);

get_header(); ?>
        <div id="primary">
            <div id="content" role="main">
                <div class="container-fluid">
                    <?php if ($response instanceof PaymentNotFoundResult) { ?>
                        Betaling is niet gevonden
                    <?php } else if ($response instanceof PaymentFailedResult) { ?>
                        Betaling is niet gelsaagd
                    <?php } else if ($response instanceof CreatePaymentEventResult) { ?>
                        Betaling is voltooid
                    <?php } ?>
                </div>
            </div><!-- #content -->
        </div><!-- #primary -->
<?php get_footer(); ?>
