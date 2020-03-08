<?php

use EventRegistration\Registration\Commands\CreateRegistrationCommand;
use EventRegistration\Registration\Commands\EventNotFoundResult;
use EventRegistration\Registration\Commands\CreateRegistrationEventResultSucces;
use EventRegistration\Registration\RegistrationCommandHandler;

$cmd = new CreateRegistrationCommand(get_query_var('eventtitle'));
global $wpdb;
$handler = new RegistrationCommandHandler($wpdb);

if ($_POST)
{
    $cmd->SetPost($_POST);
}

$response = $handler->HandeCreateEvent($cmd);

get_header('full-width'); ?>

    <div id="primary">
        <div id="content" role="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1">&nbsp;</div>

                        <?php if ($response instanceof EventNotFoundResult) { ?>
                            <div>Event is niet gevonden</div>
                        <?php } else if ($response instanceof CreateRegistrationEventResultSucces) { ?>

                            <div class="col-md-10">
                                <div class="row">Controleer hieronder je gegevens. Indien deze goed ingevuld zijn kun je door naar de betaling.</div><br />
                                <div class="itemtable">
                                    <div class="item"><b>Voornaam:</b></div>
                                    <div class="item"> <?php echo $response->getfirstname(); ?> </div>

                                    <div class="item"><b>Tussenvoegsel:</b></div>
                                    <div class="item"> <?php echo $response->getsurname(); ?> </div>

                                    <div class="item"><b>Achternaam:</b></div>
                                    <div class="item"> <?php echo $response->GetLastName(); ?> </div>

                                    <div class="item"><b>Geboortedatum:</b></div>
                                    <div class="item"> <?php echo $response->GetBirthDate(); ?> </div>

                                    <div class="item"><b>Geboorteplaats:</b></div>
                                    <div class="item"> <?php echo $response->GetCityOfBirth(); ?> </div>

                                    <div class="item"><b>Email adres:</b></div>
                                    <div class="item"> <?php echo $response->GetEmail(); ?> </div>

                                    <div class="item"><b>Telefoon:</b></div>
                                    <div class="item"> <?php echo $response->GetPhone(); ?> </div>

                                    <div class="item"><b>Document nummer:</b></div>
                                    <div class="item"> <?php echo $response->GetDocumentNr(); ?> </div>

                                    <div class="item"><b>Type identificatie:</b></div>
                                    <div class="item"> <?php echo $response->GetIdType(); ?> </div>

                                    <div class="item"><b>Prijs:</b></div>
                                    <div class="item"> &euro; <?php echo $response->GetPrice(); ?> </div>

                                    <div class="item"><b>Ingeschreven als:</b> </div>
                                    <div class="item"> <?php echo $response->GetIsRunner() ? 'Hardloper' : 'Toeschouwer'; ?> </div>

                                    <div class="itemsubmit">
                                        <br />
                                        <a href="<?php echo $response->GetPaymentUrl(); ?>" class="btn">Betalen</a>
                                        <br />
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1">&nbsp;</div>
                        <?php } else { ?>

                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12 h3">
                              <?php
                                $pageid = get_the_id();
                                $content_post = get_post($pageid);
                                $content = $content_post->post_content;
                                $content = apply_filters('the_content', $content);
                                $content = str_replace(']]>', ']]&gt;', $content);
                                echo $content;?>
                            </div>
                        </div>
                        <?php if (is_array($response->GetErrors())) { ?>
                            <div class="row">
                                <ul class="form-errors">
                                <?php foreach ($response->GetErrors() as $error) {?>
                                    <li>&bull; <?php echo $error[0]; ?></li>
                                <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div role="form" dir="ltr">
                                <div class="screen-reader-response"></div>
                                    <form action="/index.php/event/<?php echo get_query_var('eventtitle'); ?>" method="post" class="wpcf7-form">
                                    <div id="eventRegistration">
                                        <div class="er-form-row-first">
                                            <i class="form-icon fa fa-user"></i><br>
                                            <span class="wpcf7-form-control-wrap">
                                                <input
                                                    type="text"
                                                    class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                    name="firstName"
                                                    required
                                                    value="<?php echo $response->GetValue('firstName'); ?>"
                                                    size="40"
                                                    id="firstName"
                                                    aria-required="true"
                                                    aria-invalid="true"
                                                    placeholder="Naam*">
                                            </span>
                                        </div>

                                        <div class="er-form-row-first">
                                            <i class="form-icon fa fa-user"></i><br>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input
                                                type="text"
                                                class="form-control wpcf7-form-control wpcf7-text"
                                                name="surName"
                                                value="<?php echo $response->GetValue('surName'); ?>"
                                                id="surName"
                                                size="20"
                                                aria-required="true"
                                                aria-invalid="false"
                                                placeholder="tussenvoegsel">
                                            </span>
                                        </div>

                                        <div class="er-form-row-first">
                                            <i class="form-icon fa fa-user"></i><br>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input
                                                type="text"
                                                class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                name="lastName"
                                                value="<?php echo $response->GetValue('lastName'); ?>"
                                                id="lastName"
                                                required
                                                size="40"
                                                aria-required="true"
                                                aria-invalid="false"
                                                placeholder="Achternaam*">
                                            </span>
                                        </div>

                                        <div class="er-form-row">
                                            <i class="form-icon fa fa-user"></i><br>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input
                                                type="date"
                                                class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                name="birthdate"
                                                value="<?php echo $response->GetValue('birthdate'); ?>"
                                                id="birthdate"
                                                required
                                                size="50"
                                                aria-required="true"
                                                aria-invalid="false"
                                                placeholder="Geboortedatum*">
                                            </span>
                                        </div>

                                        <div class="er-form-row">
                                            <i class="form-icon fa fa-user"></i><br>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input
                                                type="text"
                                                class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                name="cityOfBirth"
                                                value="<?php echo $response->GetValue('cityOfBirth'); ?>"
                                                required
                                                size="50"
                                                id="cityOfBirth"
                                                aria-required="true"
                                                aria-invalid="false"
                                                placeholder="Geboorteplaats*">
                                            </span>
                                        </div>

                                        <div class="er-form-row">
                                            <i class="form-icon fa fa-envelope"></i><br>
                                            <span class="wpcf7-form-control-wrap your-email">
                                                <input
                                                type="email"
                                                class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                name="email"
                                                value="<?php echo $response->GetValue('email'); ?>"
                                                id="email"
                                                required
                                                size="50"
                                                aria-required="true"
                                                aria-invalid="false"
                                                placeholder="E-mail*">
                                            </span>
                                        </div>

                                        <div class="er-form-row">
                                            <i class="form-icon fa fa-phone"></i><br>
                                            <span class="wpcf7-form-control-wrap your-email">
                                                <input
                                                type="tel"
                                                class="form-control wpcf7-form-control wpcf7-text"
                                                name="phone"
                                                value="<?php echo $response->GetValue('phone'); ?>"
                                                id="phone"
                                                size="50"
                                                aria-required="true"
                                                aria-invalid="false"
                                                placeholder="Telefoon">
                                            </span>
                                        </div>

                                        <div class="er-form-row">
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <small>Type indentificatie: </small>
                                                <select class="form-control form-control-lg" name="idType" required id="idType">
                                                    <option value="">
                                                    </option>
                                                    <option value="id"
                                                        <?php echo $response->GetValue('idType') == 'id' ? 'selected="selected"':''; ?>>
                                                        Id kaart
                                                    </option>
                                                    <option value="passport"
                                                        <?php echo $response->GetValue('idType') == 'passport' ? 'selected="selected"':''; ?>>
                                                        Paspoort
                                                    </option>
                                                    <option value="driver"
                                                        <?php echo $response->GetValue('idType') == 'driver' ? 'selected="selected"':''; ?>>
                                                        Rijbewijs
                                                    </option>
                                                </select>
                                            </span>
                                        </div>

                                        <div class="er-form-row">
                                            <i class="form-icon fa fa-address-card"></i><br>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input
                                                type="text"
                                                class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                name="docNr"
                                                value="<?php echo $response->GetValue('docNr'); ?>"
                                                id="docNr"
                                                size="50"
                                                aria-describedby="docNrHelp"
                                                aria-required="true"
                                                aria-invalid="false"
                                                placeholder="Documentnr*">
                                                <!-- <small id="docNrHelp">Document nr is noodzakelijk voor toegang tot de basis</small> -->
                                            </span>
                                        </div>

                                        <div class="er-form-row">
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <small>Ik ga mee als: </small>
                                                <select class="form-control form-control-lg" name="registrationType" id="registrationType">
                                                <option value="runner"
                                                    <?php echo $response->GetValue('registrationType') == 'runner' ? 'selected="selected"':''; ?>>
                                                    Hardloper
                                                </option>
                                                <option value="spectator"
                                                    <?php echo $response->GetValue('registrationType') == 'spectator' ? 'selected="selected"':''; ?>>
                                                    Toeschouwer
                                                </option>
                                                </select>
                                            </span>
                                        </div>
                                </div>

                                        <div class="form-row form-check">
                                            <input type="checkbox" class="form-check-input " required="" name="voorwaarden" id="voorwaarden">
                                            <label class="form-check-label" for="voorwaarden">Ik ga akkoord met de  <a href="/index.php/voorwaarden" target="_blank">algemene voorwaarden</a></label>
                                        </div>
                                        <!-- <input type="submit" value="Verzenden" class="wpcf7-form-control wpcf7-submit btn btn-primary">  -->
                                        <input type="submit" value="Verzenden" class="btn btn-primary">
                                        <div class="vc_empty_space" style="height: 35px"><span class="vc_empty_space_inner"></span></div>
                                </div>
                                </form>

                        </div>
                    </div>
                        <?php } ?>
                    <div class="col-md-1">&nbsp;</div>
                </div>
            </div>
        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>
