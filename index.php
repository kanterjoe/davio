<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 12/7/16
 * Time: 10:38 PM
 */
$SETTINGS_FILE = $_SERVER['DOCUMENT_ROOT']."/settings/settings.json";


include_once $_SERVER['DOCUMENT_ROOT']."/objects/scene.php";
$sceneList = array();
$currentScene = json_decode(file_get_contents($SETTINGS_FILE))->current_scene;


foreach (scandir($_SERVER['DOCUMENT_ROOT'].scene::$FILE_DIRECTORY) as $filename) {
    if ($filename != '.' && $filename != '..') {
        $sceneList[json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].scene::$FILE_DIRECTORY.$filename))->name] = $filename;
    }
}



$other_js = <<<OJ
<script src="/js/actions.js"></script>
OJ;


include "views/head.php";
?>

<div class="card mt-4">
    <div class="card-header"><h5>Current Scene:</h5></div>
    <div class="card-block p-2">
        <form action="/form_handlers/set_global_settings.php" method="post" >
            <div id="current-scene-selector"></div>
            <div>
                <button class="btn btn-primary mt-2" type="submit">Save</button>
            </div>
        </form>
    </div>

</div>
<script>
var sceneList = <?php echo json_encode($sceneList);?> ;
var docload = function() {
    $('#current-scene-selector').append(new selectList(sceneList, '<?php echo $currentScene;?>', {"name":"current_scene"}));
};


</script>


<?php include "views/foot.php";?>
