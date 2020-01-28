<?php

use EventRegistration\partials\PublicDisplay;
$foo = new PublicDisplay();

$step = get_query_var('part', '1');

get_header(); ?>

        <div id="primary">
            <div id="content" role="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-1">&nbsp;</div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 h3">Inschrijven voor <?php echo get_query_var('eventtitle') ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 h3">
                                    1-2-3...
                                </div>
                            </div>

                            <form action="/event/<?php echo get_query_var('eventtitle') ?>" method="post"">
                                <div class="form-group">
                                    <label for="initials">Initialen <small>*</small></label>
                                    <input type="text" required class="form-control" id="initials" />
                                </div>
                                <div class="form-group">
                                    <label for="tussenvoegsel">tussenvoegsel</label>
                                    <input type="text" class="form-control" id="tussenvoegsel" />
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Achternaam <small>*</small></label>
                                    <input type="text" required class="form-control" id="email" />
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address <small>*</small></label>
                                    <input type="email" required class="form-control" id="email" />
                                </div>
                                <div class="form-group">
                                    <label for="phone">Telefoon</label>
                                    <input type="phone" required class="form-control" id="phone" />
                                </div>
                                <div class="form-group">
                                    <label for="docNr">Document nr <small>*</small></label>
                                    <input type="text" required class="form-control" id="docNr" aria-describedby="docNrHelp" />
                                    <small id="docNrHelp">Document nr is noodzakelijk voor toegang tot de basis/small>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" required id="voorwaarden">
                                    <label class="form-check-label" for="voorwaarden">Ik ga akkoord met de voorwaarden</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>

                        <div class="col-md-1">&nbsp;</div>
                    </div>
                </div>
            </div><!-- #content -->
        </div><!-- #primary -->
<?php get_footer(); ?>
