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

get_header(); ?>


        <div id="primary">
            <div id="content" role="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-1">&nbsp;</div>

                        <?php if ($response instanceof EventNotFoundResult) { ?>
                            <div>Event is niet gevonden</div>
                        <?php } else if ($response instanceof CreateRegistrationEventResultSucces) { ?>
                            <div class="row">
                                <a href="<?php echo $response->GetPaymentUrl(); ?>">Naar ideal</a>
                            </div>

                            <table class="table">
                                <tr>
                                    <th>Voornaam</th>
                                    <td>
                                        <?php echo $response->GetFirstName(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Tussenvoegsel</th>
                                    <td>
                                        <?php echo $response->GetSurName(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Achternaam</th>
                                    <td>
                                        <?php echo $response->GetLastName(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Geboortedatum</th>
                                    <td>
                                        <?php echo $response->GetBirthDate(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Geboortestad</th>
                                    <td>
                                        <?php echo $response->GetCityOfBirth(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Email addres</th>
                                    <td>
                                        <?php echo $response->GetEmail(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Telefoon</th>
                                    <td>
                                        <?php echo $response->GetPhone(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Document nummer</th>
                                    <td>
                                        <?php echo $response->GetDocumentNr(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Type identificatie</th>
                                    <td>
                                        <?php echo $response->GetIdType(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Prijs</th>
                                    <td>
                                        &euro; <?php echo $response->GetPrice(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Ingeschreven als</th>
                                    <td>
                                        <?php echo $response->GetIsRunner() ? 'Hardloper' : 'Toeschouwer'; ?>
                                    </td>
                                </tr>

                            </table>

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
                                    <label for="firstName">Voornaam <small>*</small></label>
                                    <input
                                        type="text"
                                        class="form-control <?php echo $response->GetClass('firstName'); ?>"
                                        name="firstName"
                                        required
                                        value="<?php echo $response->GetValue('firstName'); ?>"
                                        id="firstName" />
                                        <?php if ($response->GetClass('firstName') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['firstName'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>

                                <div class="form-row">
                                    <label for="surName">Tussenvoegsel</label>
                                    <input
                                        type="text"
                                        class="form-control <?php echo $response->GetClass('surName'); ?>"
                                        name="surName"
                                        value="<?php echo $response->GetValue('surName'); ?>"
                                        id="surName" />
                                        <?php if ($response->GetClass('surName') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['surName'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>

                                <div class="form-row">
                                    <label for="lastName">Achternaam <small>*</small></label>
                                    <input
                                        type="text"
                                        required
                                        class="form-control <?php echo $response->GetClass('lastName'); ?>"
                                        name="lastName"
                                        value="<?php echo $response->GetValue('lastName'); ?>"
                                        id="lastName" />
                                        <?php if ($response->GetClass('lastName') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['lastName'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>

                                <div class="form-row">
                                    <label for="birthdate">Geboortedatum <small>*</small></label>
                                    <input
                                        type="date"
                                        required
                                        class="form-control <?php echo $response->GetClass('birthdate'); ?>"
                                        name="birthdate"
                                        value="<?php echo $response->GetValue('birthdate'); ?>"
                                        id="birthdate" />
                                        <?php if ($response->GetClass('birthdate') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['birthdate'][0]; ?>
                                            </div>
                                        <?php } ?>
                                </div>

                                <div class="form-row">
                                    <label for="cityOfBirth">Geboorte stad <small>*</small></label>
                                    <input
                                        type="text"
                                        required
                                        class="form-control <?php echo $response->GetClass('cityOfBirth'); ?>"
                                        name="cityOfBirth"
                                        value="<?php echo $response->GetValue('cityOfBirth'); ?>"
                                        id="cityOfBirth" />
                                        <?php if ($response->GetClass('cityOfBirth') == 'is-invalid') { ?>
                                            <div class="invalid-feedback">
                                                <?php echo $response->GetErrors()['cityOfBirth'][0]; ?>
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
                                        type="tel"
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

                                <div class="form-row">
                                    <label for="idType">Type identificatie <small>*</small></label>
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
                                    <?php if ($response->GetClass('idType') == 'is-invalid') { ?>
                                        <div class="invalid-feedback">
                                            <?php echo $response->GetErrors()['idType'][0]; ?>
                                        </div>
                                    <?php } ?>
                                </div>


                                <div class="form-row">
                                    <label for="registrationType">Soort registratie <small>*</small></label>
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
                                    <?php if ($response->GetClass('registrationType') == 'is-invalid') { ?>
                                        <div class="invalid-feedback">
                                            <?php echo $response->GetErrors()['registrationType'][0]; ?>
                                        </div>
                                    <?php } ?>
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
