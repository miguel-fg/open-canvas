<?php

function colour_preview(){
    echo '<div><canvas id="colour-preview"></canvas></div>';
}

function sliders(){
    echo '<div class="sliders-container">';
    echo '<label for="red">R</label>';
    echo '<input type="range" min="0" max="255" value="0" class="slider" id="red"><br />';
    echo '<label for="green">G</label>';
    echo '<input type="range" min="0" max="255" value="0" class="slider" id="green"><br />';
    echo '<label for="blue">B</label>';
    echo '<input type="range" min="0" max="255" value="0" class="slider" id="blue"><br />';
    echo '<label for="alpha">A</label>';
    echo '<input type="range" min="0" max="1" step="0.01" value="1" class="slider" id="alpha"><br />';
    echo '</div>';
}

function get_colour_picker(){
    echo '<div class="colour-picker">';
    echo colour_preview();
    echo sliders();
    echo '</div>';
}

?>