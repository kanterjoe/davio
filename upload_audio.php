<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/18/17
 * Time: 1:51 PM
 */
include $_SERVER['DOCUMENT_ROOT']."/views/head.php";
?>
<div class="card mt-4">
    <div class="card-header"><h4>Upload File</h4></div>
    <div class="card-block">
        <form action="/form_handlers/upload_audio_file.php" method="post" enctype="multipart/form-data">
            <label class="custom-file">
                <input type="file" id="audiofile" name="audiofile" class="custom-file-input">
                <span class="custom-file-control"></span>
            </label>
            <button type="submit" class="btn btn-primary">Upload</button>

        </form>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/views/foot.php"; ?>