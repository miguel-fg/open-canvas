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
        <div class="modal" id="save-modal">
            <div class="save-form">
                <button class="closeModalbtn" onclick="closeModal()">
                    <img src="./icons/close-circle-svgrepo-com.svg" class="tool-icon" style="width: 35px;" />
                </button>
                <div class="form-content">
                    <h2>Save Drawing</h2>
                    <form action="" method="post">
                        <label for="title">Title: </label><br>
                        <input type="text" name="title" id="title"><br>
                        <label for="description">Description: </label><br>
                        <textarea></textarea><br>
                        <button type="submit" class="submitbtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
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
                <button class="save-btn" onclick="openModal()">Save</button>
            </div>
        </div>
    </div>
    <script>
        let modal = document.querySelector("#save-modal");

        function openNav() {
            document.querySelector("#sidebar").style.width = "250px";
        }

        function hideNav() {
            document.querySelector("#sidebar").style.width = "0";
        }

        function openModal() {
            modal.style.display = "block";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = (e) => {
            if(e.target == modal){
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>