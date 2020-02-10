<?php
declare(strict_types=1);

namespace EventRegistration\Admin\Partials;

use EventRegistration\Options\Commands\CreateOptionsCommand;
use EventRegistration\Options\OptionsCommandHandler;

if (! defined('WPINC')) {
    die;
}

class DisplayOptions
{
    public static function render(): void
    {
        $mollieApiKey = get_option('er_mollieApiKey');

        global $wpdb;

        $errors = [];
        if($_POST) {
            //create command
            $cmd = new CreateOptionsCommand();

            if (isset($_POST['mollieApiKey'])) {
                $cmd->SetMollieApiKey($_POST['mollieApiKey']);
            }

            $optionsHandler = new OptionsCommandHandler($wpdb);

            // execute command
            $res = $optionsHandler->HandleEvent($cmd);

            if ($res->GetSucess()) {
                ?>
                <div class="wrap">
                    <h1>Events opties</h1>
                    Opties zijn opgeslagen
                </div>
                <?php
                return;
            }

            $mollieApiKey = $_POST['mollieApiKey'];
            $errors = $res->GetErrors();
        }
        ?>
            <div class="wrap">
                <h1>Events opties</h1>

                <?php if (count($errors) > 0) { ?>

                    <div id="setting-error-invalid_siteurl" class="notice notice-error settings-error is-dismissible">
                        <?php foreach ($errors as $error) { ?>
                            <p><strong><?php echo $error[0]; ?></strong></p>
                        <?php } ?>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>
                <?php } ?>

                <form action="" method="post">
                    <tr class="">
                        <th><label for="mollieApiKey">Mollie API key</label></th>
                        <td><input type="text" name="mollieApiKey" id="mollieApiKey" value="<?php echo $mollieApiKey; ?>" class="regular-text" max="50" /></td>
                    </tr>
                    <?php submit_button(); ?>
                </form>
            </div>

        <?php
    }
}
