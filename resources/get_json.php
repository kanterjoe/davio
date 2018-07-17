<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/19/17
 * Time: 3:33 PM
 */


$resource_type = $_GET['resource_type'];
$output = array();
foreach (scandir($_SERVER['DOCUMENT_ROOT']."/resources/".$resource_type) as $filename) {
    if ($filename != '.' && $filename != '..') {
        array_push($output, $filename);
    }
}

echo json_encode($output);