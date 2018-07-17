<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 12/30/16
 * Time: 3:59 PM
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL);

$button_number = $_POST['device'];
$actions = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT']."/settings/actions.json")
);

$actions->$button_number->action    = $_POST['action'];
$actions->$button_number->resource  = $_POST['resource'];

$suc = file_put_contents($_SERVER['DOCUMENT_ROOT']."/settings/actions.json",json_encode($actions) );

if ($suc === false)
    die();

header( 'Location: /' ) ;


?>