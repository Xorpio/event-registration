<?php

use EventRegistration\Registration\Commands\CreateRegistrationCommand;
use EventRegistration\Registration\Commands\EventNotFoundResult;
use EventRegistration\Registration\RegistrationCommandHandler;

$cmd = new CreateRegistrationCommand(get_query_var('eventtitle'));
global $wpdb;
$handler = new RegistrationCommandHandler($wpdb);

if ($_POST)
{
    $cmd->SetPost($_POST);
}

$response = $handler->HandeCreateEvent($cmd);

get_header(); ?>


        <div id="primary">
            <div id="content" role="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-1">&nbsp;</div>

                        <?php if ($response instanceof EventNotFoundResult) { ?>
                            <div>Event is niet gevonden</div>
                        <?php } else { ?>


                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 h3">Inschrijven voor <?php echo $response->GetTitle() ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 h3">
                                    1-2-3...
                                </div>
                            </div>

                            <form action="/event/<?php echo get_query_var('eventtitle') ?>" method="post"">
                                <div class="form-row">
                                    <label for="initials">Initialen <small>*</small></label>
                                    <input
                                        type="text"
                                        class="form-control <?php echo $response->GetClass('initials'); ?>"
                                        name="initials"
                                        required
                                        value="<?php echo $response->GetValue('initials'); ?>"
                                        id="initials" />
                                        <?php if ($response->GetClass('initials') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['initials'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>
                                <div class="form-row">
                                    <label for="surname">Tussenvoegsel</label>
                                    <input
                                        type="text"
                                        class="form-control <?php echo $response->GetClass('surname'); ?>"
                                        name="surname"
                                        value="<?php echo $response->GetValue('surname'); ?>"
                                        id="surname" />
                                        <?php if ($response->GetClass('surname') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['surname'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>
                                <div class="form-row">
                                    <label for="lastname">Achternaam <small>*</small></label>
                                    <input
                                        type="text"
                                        required
                                        class="form-control <?php echo $response->GetClass('lastname'); ?>"
                                        name="lastname"
                                        value="<?php echo $response->GetValue('lastname'); ?>"
                                        id="lastname" />
                                        <?php if ($response->GetClass('lastname') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['lastname'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>
                                <div class="form-row">
                                    <label for="email">Email address <small>*</small></label>
                                    <input
                                        type="email"
                                        required
                                        class="form-control <?php echo $response->GetClass('email'); ?>"
                                        name="email"
                                        value="<?php echo $response->GetValue('email'); ?>"
                                        id="email" />
                                        <?php if ($response->GetClass('email') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['email'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>
                                <div class="form-row">
                                    <label for="phone">Telefoon</label>
                                    <input
                                        type="text"
                                        required
                                        class="form-control <?php echo $response->GetClass('phone'); ?>"
                                        name="phone"
                                        value="<?php echo $response->GetValue('phone'); ?>"
                                        id="phone" />
                                        <?php if ($response->GetClass('phone') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['phone'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>
                                <div class="form-row">
                                    <label for="docNr">Document nr <small>*</small></label>
                                    <input
                                        type="text"
                                        required
                                        class="form-control <?php echo $response->GetClass('docNr'); ?>"
                                        name="docNr"
                                        value="<?php echo $response->GetValue('docNr'); ?>"
                                        id="docNr"
                                        aria-describedby="docNrHelp" />
                                        <?php if ($response->GetClass('docNr') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['docNr'][0]; ?>
                                            </div>
                                        <?php } ?>
                                    <small id="docNrHelp">Document nr is noodzakelijk voor toegang tot de basis</small>
                                </div>
                                <div class="form-row form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input <?php echo $response->GetClass('voorwaarden'); ?>"
                                        required
                                        name="voorwaarden"
                                        id="voorwaarden">
                                    <label class="form-check-label" for="voorwaarden">Ik ga akkoord met de voorwaarden</label>
                                        <?php if ($response->GetClass('voorwaarden') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['voorwaarden'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>

                        <?php } ?>

                        <div class="col-md-1">&nbsp;</div>
                    </div>
                </div>
            </div><!-- #content -->
        </div><!-- #primary -->
<?php get_footer(); ?>
