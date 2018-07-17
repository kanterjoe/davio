<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/18/17
 * Time: 1:58 PM
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once $_SERVER['DOCUMENT_ROOT']."/objects/scene.php";
include_once $_SERVER['DOCUMENT_ROOT']."/includes/action_funcs.php";

function FormatCSSSpecialChars($str) {
    $str = str_ireplace(" ",  "_s", $str);
    $str = str_ireplace(".",  "_p", $str);
    $str = str_ireplace("/",  "_f", $str);
    $str = str_ireplace("\\", "_b", $str);


    return $str;
}
function build_input_device ($input_device, $name="") {
    $checked = ($input_device->enabled? "Checked":"");
    $str  = "<div class='card'> <div class=\"card-block\">";
    $str .= "<h4 class='card-title'>$name</h4>";
    $str .= "<label class=\"form-check-label\">".
         "<input type=\"checkbox\" class=\"form-check-input\" $checked>".
        "Enable</label>";

    foreach ($input_device->actions as $action) {
        $str .= build_action($action,$name);
    }
    $str .= "</div></div>";
    return $str;
}
function build_action ($action, $name) {
    /*
     * {
          "action":"Play Audio",
          "resource": "res.wav",
          "arguments":""
        },
     */
    $str  = "<div class='row'>";
    $str .= "<h3>Action:</h3>";
    $str .= available_actions_dropdown($name, $action->action);
    if ($action->action === "Play Audio") $str .= "<h3>Resource:</h3>".available_audio_dropdown($name, $action->resource);
    if ($action->action === "Play Audio") $str .= "<h3>Resource:</h3>".available_lights_dropdown($name, $action->resource);
    $str .= "</div>";
    return $str;

}


?>


<div id="scene-container">
    <div>
        <button class="btn btn-warning" role="button" id="new-scene-button">New Scene</button>
    </div>
    <div id="scene-accordion" role="tablist" aria-multiselectable="true">



    </div>
</div>
<script>
    document.onload = function() {

<?php
foreach (scandir($_SERVER['DOCUMENT_ROOT'].scene::$FILE_DIRECTORY) as $filename) {
    if ($filename != '.' && $filename != '..') {
        echo "get_scene('" . $filename . "');";
    }
}
?>
    };
</script>