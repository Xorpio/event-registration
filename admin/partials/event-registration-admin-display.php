<?php
namespace EventRegistration;

use EventRegistration\Event\Queries\ListEventQuery;
use EventRegistration\Event\Commands\CreateEventCommand;
use EventRegistration\Event\Commands\CreateEventResult;
use EventRegistration\Event\EventCommandHandler;

if (! defined('WPINC')) {
    die;
}

class Event_Registration_Admin_Display_Event_List
{
    public static function render()
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

        switch ($action) {
            case 'add':
                self::renderAdd();
            break;
            default:
                self::renderList();
            break;
        }
    }

    private static function renderAdd()
    {
        global $wpdb;

        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $slots = isset($_POST['slots']) ? $_POST['slots'] : null;
        $startRegistration = isset($_POST['startRegistration']) ? $_POST['startRegistration'] : null;
        $endRegistration = isset($_POST['endRegistration']) ? $_POST['endRegistration'] : null;
        $eventDate = isset($_POST['eventDate']) ? $_POST['eventDate'] : null;
        $eventType = isset($_POST['eventType']) ? $_POST['eventType'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $spectatorPrice = isset($_POST['spectatorPrice']) ? $_POST['spectatorPrice'] : null;
        $tax = isset($_POST['tax']) ? $_POST['tax'] : null;

        $errors = [];
        if($_POST) {
            //create command
            $cmd = (new CreateEventCommand())
                ->SetTitle($title)
                ->SetSlots($slots)
                ->SetStartRegistrationDate(\DateTime::createFromFormat("Y-m-d", $startRegistration))
                ->SetEndRegistrationDate(\DateTime::createFromFormat("Y-m-d", $endRegistration))
                ->SetEventDate(\DateTime::createFromFormat("Y-m-d", $eventDate))
                ->SetEventType($eventType)
                ->SetPrice(floatval(str_replace(',', '.', $price)))
                ->SetSpectatorPrice(floatval(str_replace(',', '.', $spectatorPrice)))
                ->SetTax(intval($tax));
            ;
            $eventHandler = new EventCommandHandler($wpdb);

            // execute command
            $res = $eventHandler->HandeCreateEvent($cmd);

            if ($res->GetSucess()) {
                ?>
                <div class="wrap">
                    <h1>Events</h1>
                    Event is opgeslagen.
                </div>
                <?php
                return;
            }

            $errors = $res->GetErrors();
        }

        ?>
        <div class="wrap">
        <h1>Events</h1>
            <?php if (count($errors) > 0) { ?>
                <div id="setting-error-invalid_siteurl" class="notice notice-error settings-error is-dismissible">
                    <?php foreach ($errors as $error) { ?>
                        <p><strong><?php echo $error[0]; ?></strong></p>
                    <?php } ?>
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                </div>
            <?php } ?>
        <form action="" method="post">
            <table class="form-table" role="presentation">
                <tbody>
                    <tr class="">
                        <th><label for="title">Titel</label></th>
                        <td><input type="text" name="title" id="title" value="<?php echo $title; ?>" class="regular-text" max="50" required ></td>
                    </tr>
                    <tr class="">
                        <th><label for="slots">Plaatsen</label></th>
                        <td><input type="number" name="slots" id="slots" value="<?php echo $slots; ?>" class="regular-text" min="1" required ></td>
                    </tr>
                    <tr class="">
                        <th><label for="startRegistration">Start inschrijving</label></th>
                        <td><input type="date" name="startRegistration" id="startRegistration" value="<?php echo $startRegistration; ?>" class="regular-text" required ></td>
                    </tr>
                    <tr class="">
                        <th><label for="endRegistration">Einde inschrijving</label></th>
                        <td><input type="date" name="endRegistration" id="endRegistration" value="<?php echo $endRegistration; ?>" class="regular-text" ></td>
                    </tr>
                    <tr class="">
                        <th><label for="eventDate">Event datum</label></th>
                        <td><input type="date" name="eventDate" id="eventDate" value="<?php echo $eventDate; ?>" class="regular-text" required ></td>
                    </tr>
                    <tr class="">
                        <th><label for="eventType">eventType</label></th>
                        <td>
                            <select name="eventType" id="eventType" required >
                                <option value=""></option>
                                <option value="run"
                                    <?php if ($eventType == 'run') echo ' selected="selected"'; ?>
                                >Hardloop event</option>
                                <option value="dartdrive"
                                    <?php if ($eventType == 'dartdrive') echo ' selected="selected"'; ?>
                                >Dartdrive event</option>

                            </select>
                        </td>
                    </tr>
                    <tr class="">
                        <th><label for="price">Prijs(&euro;)</label></th>
                        <td><input
                            type="text"
                            name="price"
                            id="price"
                            value="<?php echo $price; ?>"
                            class="regular-text"
                            required
                            pattern="\d+,\d{2}"
                            title="Bijvoorbeeld: 1,50"
                        ></td>
                    </tr>
                    <tr class="">
                        <th><label for="spectatorPrice">Toeschouwer prijs(&euro;)</label></th>
                        <td><input
                            type="text"
                            name="spectatorPrice"
                            id="spectatorPrice"
                            value="<?php echo $spectatorPrice; ?>"
                            class="regular-text"
                            required
                            pattern="\d+,\d{2}"
                            title="Bijvoorbeeld: 1,50"
                        ></td>
                    </tr>
                    <tr class="">
                        <th><label for="tax">BTW(%)</label></th>
                        <td><input
                            type="number"
                            name="tax"
                            id="tax"
                            value="<?php echo $tax; ?>"
                            class="regular-text"
                            min="0"
                            max="50"
                            required
                        ></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save event"></p>
        </form>
        </div>
        <?php
    }

    private static function renderList()
    {
        global $wpdb;

        $eventData = (new ListEventQuery($wpdb))->GetEventList();

        //Create an instance of our package class...
        $testListTable = new EventTable();
        //Fetch, prepare, sort, and filter our data...
        $testListTable->prepare_items($eventData); ?>

        <div class="wrap">

            <h1>
                Events
                <a href="?page=event&action=add" class="page-title-action">Add Event</a>
            </h1>
            <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
            <form id="movies-filter" method="get">
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <!-- Now we can render the completed list table -->
                <?php $testListTable->display() ?>
            </form>

        </div>
        <?php
    }
}
