<?php

include "./templates/canvas.php";
include "./templates/tools.php";
include "./templates/colourPicker.php";
include "./database/database.php";

$projectId = isset($_GET["id"]) ? $_GET["id"] : null;
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
        <a href="#" onclick="return false;" class="nav-link">New Project</a>
        <a href="documentation.html" class="nav-link">Documentation</a>
    </div>
    <div class="content">
        <div class="modal" id="save-modal">
            <div class="save-form">
                <button class="closeModalbtn" onclick="closeModal()">
                    <img src="./icons/close-circle-svgrepo-com.svg" class="tool-icon" style="width: 35px;" />
                </button>
                <div class="form-content">
                    <h2>Save Project</h2>
                    <form id="submit-form" method="post">
                        <label for="title">Title: </label><br>
                        <input type="text" name="title" id="title"><br>
                        <span class="error-msg" id="title-error"></span><br>
                        <label for="description">Description: </label><br>
                        <textarea name="description" id="description" rows="4"></textarea><br>
                        <span class="error-msg" id="description-error"></span><br>
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
                <?php get_canvas($projectId) ?>
            </div>
            <div class="div2">
                <?php get_tool_ribbon() ?>
                <button class="save-btn" onclick="openModal()">Save</button>
            </div>
        </div>
        <div class="toast" id="toast">Project saved!</div>
    </div>
    <script>
        const modal = document.querySelector("#save-modal");
        const form = document.querySelector("#submit-form");
        const projectId = <?php echo json_encode($projectId); ?>

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
            clearErrorMessages();
        }

        function sendToast() {
            const toast = document.querySelector("#toast");

            toast.className = "show";

            setTimeout(function() {
                toast.className = toast.className.replace("show", "");
            }, 3000);
        }

        window.onclick = (e) => {
            if (e.target == modal) {
                modal.style.display = "none";
            }
        }

        form.onsubmit = (e) => {
            e.preventDefault();

            const canvas = document.querySelector("#main-canvas");
            const imgURL = canvas.toDataURL();

            const title = document.querySelector("#title").value;
            const description = document.querySelector("#description").value;

            // frontend validation 
            const validationMessages = validate(title, description);

            if (validationMessages.title || validationMessages.description) {
                clearErrorMessages();
                displayErrorMessages(validationMessages);
            }

            const formData = new FormData();
            formData.append("title", title);
            formData.append("description", description);
            formData.append("imgURL", imgURL);

            if (projectId !== null) {
                formData.append("id", projectId);
                formData.append("action", "update_drawing");
            } else {
                formData.append("action", "submit_drawing");
            }

            // send POST request with image data
            fetch("./database/database.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        // successful backend validation
                        sendToast();
                        closeModal();
                    } else {
                        // failed backend validation
                        // comment out the following two lines to see frontend validation in action
                        clearErrorMessages();
                        displayErrorMessages(data.messages);
                    }
                });
        }

        function validate(title, description) {
            const messages = {};
            if (title.trim() === "") {
                messages.title = "Title cannot be empty";
            }

            if (description.trim() === "") {
                messages.description = "Description cannot be empty";
            }

            return messages;
        }

        function clearErrorMessages() {
            document.querySelector("#title-error").innerHTML = "";
            document.querySelector("#description-error").innerHTML = "";
        }

        function displayErrorMessages(messages) {
            if (messages.title) {
                document.querySelector("#title-error").innerHTML = messages.title;
            }

            if (messages.description) {
                document.querySelector("#description-error").innerHTML = messages.description;
            }
        }
    </script>
</body>

</html>