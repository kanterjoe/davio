<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/26/17
 * Time: 3:24 PM
 */
$SETTINGS_FILE = $_SERVER['DOCUMENT_ROOT']."/settings/settings.json";

var_dump($_REQUEST);

$settings = json_decode(file_get_contents($SETTINGS_FILE));

foreach ($_REQUEST as $setting=>$value) {
    $settings->$setting = $value;
}

var_dump($settings);

file_put_contents($SETTINGS_FILE,json_encode($settings));

header('Location: /');


