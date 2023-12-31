<?php
function get_canvas($projectId)
{
    // if there's a project id, the background of the canvas will be set to the image
    if ($projectId !== null) {
        $imagePath = get_image_path($projectId);
        $imgsrc = substr($imagePath, 2);

        echo '<canvas class="main-canvas" id="main-canvas" style="background-image: url(\'./database/' . $imgsrc . '\'); background-size: cover;">';
    } else {
        echo '<canvas class="main-canvas" id="main-canvas">';
    }
    echo '</canvas>';
}
