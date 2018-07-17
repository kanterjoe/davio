<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/18/17
 * Time: 1:51 PM
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once $_SERVER['DOCUMENT_ROOT']."/objects/scene.php";

$get_scenes = "";
foreach (scandir($_SERVER['DOCUMENT_ROOT'].scene::$FILE_DIRECTORY) as $filename) {
    if ($filename != '.' && $filename != '..') {
        $get_scenes .= "get_scene('" . $filename . "');\r\n";
    }
}

$other_js = <<< OJ
<script src="/js/actions.js"></script>
<script src="/js/scene.js"></script>
OJ;
include $_SERVER['DOCUMENT_ROOT']."/views/head.php";

?>
<script>
    var docload = function() {
        console.log("Document Loaded");
        <?php echo $get_scenes;?>

    };
</script>
<div id="scene-container" >
    <div>
        <button class="btn btn-warning" role="button" id="new-scene-button">New Scene</button>
    </div>
    <div id="scene-accordion" role="tablist" aria-multiselectable="true">



    </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT']."/views/foot.php"; ?>

