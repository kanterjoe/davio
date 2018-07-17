<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/19/17
 * Time: 2:12 PM
 */

//var_dump($_REQUEST);


$data = json_encode($_REQUEST['data']);

file_put_contents($_SERVER['DOCUMENT_ROOT'].$_REQUEST['file'], $data);

echo $data;