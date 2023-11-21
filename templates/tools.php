<?php
include "./templates/icons.php";

function get_tool_ribbon()
{
    echo '<div class="tool-ribbon">';
    echo '<input type="radio" class="tool" name="selected-tool" id="brush">';
    echo '<label for="brush">' . get_brush_icon() . '</label>';
    echo '<input type="radio" class="tool" name="selected-tool" id="eraser">';
    echo '<label for="eraser">' . get_eraser_icon() . '</label>';
    echo '<input type="radio" class="tool" name="selected-tool" id="bucket">';
    echo '<label for="bucket">' . get_bucket_icon() . '</label>';
    echo '<input type="radio" class="tool" name="selected-tool" id="clear">';
    echo '<label for="clear">' . get_clear_icon() . '</label>';
    echo '</div>';
}
