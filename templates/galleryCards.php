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
        echo '<button onclick="editProject(' . $proj['id'] . ')">';
        echo
        '<img src="./icons/edit-svgrepo-com.svg" class="card-icon" id="edit-btn" style="width: 25px;"/>';
        echo '</button>';
        echo '<button onclick="deleteProject(' . $proj['id'] . ')">';
        echo
        '<img src="./icons/delete-2-svgrepo-com.svg" class="card-icon" id="delete-btn" style="width: 25px;"/>';
        echo '</button>';
        echo '</div>';
    }
}