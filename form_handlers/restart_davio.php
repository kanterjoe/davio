<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 3/16/17
 * Time: 8:56 PM
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$output = shell_exec("shutdown -h now");

echo "<pre>".$output."</pre>";