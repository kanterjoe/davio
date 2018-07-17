<?php

/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 1/3/17
 * Time: 4:28 PM
 */

class scene
{
    public static $FILE_DIRECTORY = '/settings/scenes/';
    public $name;
    public $actions;
    public $input_devices;
    private $errors = array();


    function __construct($scene_id)
    {
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].self::$FILE_DIRECTORY.$scene_id);
        if (empty($data)) {
            $this->errors[] = "File Does not exist: ".$_SERVER['DOCUMENT_ROOT'].self::$FILE_DIRECTORY.$scene_id;
            return;
        }
        $json_data = json_decode($data);

        if (isset($json_data->name))
            $this->name = $json_data->name;
        else
            $this->errors[] = "Scene '$scene_id' has no name";

        if (isset($json_data->input_devices))
            $this->input_devices = $json_data->input_devices;
        else
            $this->errors[] = "Scene '$scene_id' has no input_devices";
    }
    function dump_input_devices () {
        return var_export($this->input_devices, true);
    }

    function errors() {
        var_dump($this->errors);
    }


}