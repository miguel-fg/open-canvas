<?php
include "./templates/icons.php";

function get_tool_ribbon()
{
    echo '<div class="tool-ribbon">';
    get_colour_picker();
    echo '<input type="radio" class="tool" name="selected-tool" id="brush">';
    echo '<label for="brush" class="tool-label">' . get_brush_icon() . '</label>';
    echo '<input type="radio" class="tool" name="selected-tool" id="eraser">';
    echo '<label for="eraser" class="tool-label">' . get_eraser_icon() . '</label>';
    echo '<input type="radio" class="tool" name="selected-tool" id="bucket">';
    echo '<label for="bucket" class="tool-label">' . get_bucket_icon() . '</label>';
    echo '<input type="radio" class="tool" name="selected-tool" id="clear">';
    echo '<label for="clear" class="tool-label">' . get_clear_icon() . '</label>';
    echo '</div>';
}
