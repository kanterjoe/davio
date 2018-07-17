<?php

/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/18/17
 * Time: 1:40 PM
 */
const ACTION_DIRECTORY = '/settings/actions';

class action
{
    private $name;
    public $actions;
    private $errors = array();


    function __construct($action_id)
    {
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].ACTION_DIRECTORY.$action_id);
        if ($data===false)
            $this->errors[] = "File Does not exist: ".$_SERVER['DOCUMENT_ROOT'].ACTION_DIRECTORY.$action_id;
        $json_data = json_decode($data);

        if (isset($json_data->name))
            $this->name = $json_data->name;
        else
            $this->errors[] = "Action '$action_id' has no name";

    }
}