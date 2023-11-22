<?php

include "./templates/canvas.php";
include "./templates/tools.php";
include "./templates/colourPicker.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="app.css">
    <title>Open Canvas</title>
    <script src="./scripts/canvas.js"></script>
</head>

<body>
    <div id="sidebar" class="sidebar">
        <button class="closebtn" onclick="hideNav()">
            <img src="./icons/close-circle-svgrepo-com.svg" class="tool-icon" style="width: 35px;" />
        </button>
        <a href="index.php" class="nav-link">Home</a>
        <a href="#" onclick="return false;" class="nav-link">New Drawing</a>
        <a href="documentation.html" class="nav-link">Documentation</a>
    </div>
    <div class="content">
        <button class="openbtn" onclick="openNav()">
            <img src="./icons/burger-menu-svgrepo-com.svg" class="tool-icon" style="width: 30px;" />
        </button>
        <h1>Open Canvas</h1>
        <div class="parent">
            <div class="div1">
                <?php get_canvas() ?>
            </div>
            <div class="div2">
                <?php get_tool_ribbon() ?>
            </div>
            <div class="div3">
                <?php get_colour_picker() ?>
            </div>
        </div>
    </div>
    <script>
        function openNav() {
            document.querySelector("#sidebar").style.width = "250px";
        }

        function hideNav() {
            document.querySelector("#sidebar").style.width = "0";
        }
    </script>
</body>

</html>
<!-- 
        <p>Your Free Space for Art</p>
-->