<?php
include "./templates/icons.php";

function get_tool_ribbon(){
    echo '<div class="tool-ribbon">';
    echo '<button class="tool" id="brush">'. get_brush_icon() .'</button>';
    echo '<button class="tool" id="eraser">'. get_eraser_icon() .'</button>';
    echo '<button class="tool" id="bucket">'. get_bucket_icon() .'</button>';
    echo '<button class="tool" id="clear">'. get_clear_icon() .'</button>';
    echo '</div>';
}

?>
