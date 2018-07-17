<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/18/17
 * Time: 8:03 PM
 */

function build_dropdown_from_array ($array, $selected="", $name="", $id="", $none_item=false) {

    $output = "<select id=\"$id\" name=\"$name\" class=\"form-control form-control-lg\">";

    if ($none_item) $output .= "<option>$none_item</option>";
    foreach ($array as $item) {
        if ($item == $selected)
            $output .= "<option selected>$item</option>";
        else
            $output .= "<option>Item</option>";

    }
    $output.="</select>";

    return $output;

}

$pins = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT']."/settings/gpio_mappings.json")
);
$actions = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT']."/settings/actions.json")
);
$available_actions = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT']."/settings/available_actions.json")
);


function available_audio_dropdown ($name, $selected=false) {
    $directory = $_SERVER['DOCUMENT_ROOT'].'/resources/';
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    return build_dropdown_from_array($scanned_directory, $selected, "available_audio_".$name, $name);
}
function available_lights_dropdown ($name, $selected=false) {
    $directory = $_SERVER['DOCUMENT_ROOT'] . '/resources/audio';
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    return build_dropdown_from_array($scanned_directory, $selected, "available_lights_".$name, $name);
}
function available_actions_dropdown ($name, $selected=false) {
    global $available_actions;
    return build_dropdown_from_array($available_actions, $selected, "available_actions_".$name, $name, "None" );
}

