<div id="device-list">
    <ul class="list-group">
<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 12/30/16
 * Time: 2:56 PM
 */

$pins = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT']."/settings/gpio_mappings.json")
);
$actions = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT']."/settings/actions.json")
);
$available_actions = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT']."/settings/available_actions.json")
);

function available_actions ($selected) {
    global $available_actions;
    $output = "";
    foreach ($available_actions as $action) {
        if ($action == (empty($selected)? "No Action":$selected))

            $output .= "<option selected>$action</option>";
        else
            $output .= "<option>$action</option>";

    }
    return $output;
}
function available_audio ($selected) {
    $directory = $_SERVER['DOCUMENT_ROOT'].'/resources/';
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    $output = "<option>None</option>";
    foreach ($scanned_directory as $resource_name) {
        if ($resource_name == (empty($selected)? "None":$selected))

            $output .= "<option selected>$resource_name</option>";
        else
            $output .= "<option>$resource_name</option>";

    }
    return $output;
}
foreach ($pins as $index=>$pin) {
    $button_number = $index + 1;

    echo "<li class=\"list-group-item\"><form action='/form_handlers/update_device.php' method='post' class='form-inline'>";
    echo "<input class=\"form-control\" type='hidden' value='$button_number' name='device'/>";

    echo "Button $button_number. On Press: ";
    echo "<select name=\"action\" class=\"form-control form-control-lg\">".
        available_actions($actions->$button_number->action).
        "</select>";
   echo "<select name=\"resource\" class=\"form-control form-control-lg\">".
        available_audio($actions->$button_number->resource).
        "</select>";
    echo "<input class=\"form-control\" type='submit' value='Save'/>";
    echo "</form></li>";

}



?>


    </ul>
</div>