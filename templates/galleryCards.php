<?php
$projects = get_drawings();

function get_cards(){
    global $projects;

    $reversedProjects = array_reverse($projects);

    foreach($reversedProjects as $proj){
        $imgPath = substr($proj['path'], 2);

        echo '<div class="gallery-card">';
        echo '<img class="thumbnail" width="400px" src="./database/' . $imgPath . '" alt="' . $proj['title'] . '">';
        echo '<h3>' . $proj['title'] . '</h3>';
        echo '<span>' . $proj['description'] . '</span>';
        echo '</div>';
    }
}