<?php

/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/18/17
 * Time: 1:40 PM
 */
const ID_DIRECTORY = '/settings/input_devices';

class input_devices
{
    public $name;
    public $gpio_pin;
    private $errors = array();


    function __construct($device_id)
    {
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].ID_DIRECTORY.$device_id);
        if ($data===false)
            $this->errors[] = "File Does not exist: ".$_SERVER['DOCUMENT_ROOT'].ID_DIRECTORY.$device_id;
        $json_data = json_decode($data);

        if (isset($json_data->name))
            $this->name = $json_data->name;
        else
            $this->errors[] = "Input Device '$device_id' has no name";
        if (isset($json_data->gpio_pin))
            $this->name = $json_data->gpio_pin;
        else
            $this->errors[] = "Input Device '$device_id' has no name";

    }
    public function __destruct()
    {
        // TODO: Implement __destruct() method.



    }
}