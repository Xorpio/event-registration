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

get_header('full-width'); ?>
        <div id="primary">
            <div id="content" role="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-1">&nbsp;</div>
                        <div class="col-md-6 paymentDone">
                            <?php if ($response instanceof PaymentNotFoundResult) { ?>
                            <h2> Betaling is niet gevonden </h2>
                            <?php } else if ($response instanceof PaymentFailedResult) { ?>
                                <h2>Betaling is niet geslaagd</h2>
                            <?php } else if ($response instanceof CreatePaymentEventResult) { ?>
                                <img src="https://team77midden-brabant.nl/wp-content/uploads/2020/03/62236532_977437219314300_8475756687481896960_n.jpg" alt="">
                                <h2>Betaling is voltooid</h2>
                                <div>
                                    Je inschrijving is nu voltooid. We zullen dit ook bevestigen via het emailadres dat ingevoerd was. Tot 19 april. Als je binnen 2 dagen geen bevestiging in de email hebt neem dan contact op de met de organisatie.
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-1">&nbsp;</div>
                    </div>
                </div>
            </div><!-- #content -->
        </div><!-- #primary -->
<?php get_footer(); ?>
