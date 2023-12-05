<?php
include "./database/database.php";
include "./templates/galleryCards.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="app.css">
    <title>Open Canvas</title>
</head>

<body>
    <div id="sidebar" class="sidebar">
        <button class="closebtn" onclick="hideNav()">
            <img src="./icons/close-circle-svgrepo-com.svg" class="tool-icon" style="width: 35px;" />
        </button>
        <a href="#" onclick="return false;" class="nav-link">Home</a>
        <a href="editor.php" class="nav-link">New Project</a>
        <a href="documentation.html" class="nav-link">Documentation</a>
    </div>
    <div class="content">
        <div class="modal" id="confirm-modal">
            <div class="confirm-content">
                <h2>Warning</h2>
                <p>Are you sure you want to delete this project?</p>
                <div class="confirm-btns">
                    <button class="confirm-btn" id="confirm" onclick="deleteConfirmed()">Confirm</button>
                    <button class="confirm-btn" id="cancel" onclick="cancelDelete()">Cancel</button>
                </div>
            </div>
        </div>
        <button class="openbtn" onclick="openNav()">
            <img src="./icons/burger-menu-svgrepo-com.svg" class="tool-icon" style="width: 30px;" />
        </button>
        <h1>Open Canvas</h1>
        <p>Your Free Space for Art</p>
        <div class="gallery-container">
            <div class="gallery-card">
                <a href="editor.php">New Project</a>
            </div>
            <?php get_cards(); ?>
        </div>
        <div class="toast" id="deleteToast">Project deleted!</div>
    </div>

    <script>
        function openNav() {
            document.querySelector("#sidebar").style.width = "250px";
        }

        function hideNav() {
            document.querySelector("#sidebar").style.width = "0";
        }

        function sendToast() {
            const toast = document.querySelector("#deleteToast");

            toast.className = "show";

            setTimeout(function() {
                toast.className = toast.className.replace("show", "");
            }, 3000);
        }

        function editProject(projectId) {
            window.location.href = 'editor.php?id=' + projectId;
        }

        function deleteProject(projectId) {
            const modal = document.querySelector("#confirm-modal");
            modal.style.display = "block"

            modal.setAttribute("card-project-id", projectId);
        }

        function cancelDelete() {
            document.querySelector("#confirm-modal").style.display = "none";
        }

        function deleteConfirmed() {
            document.querySelector("#confirm-modal").style.display = "none";

            const projectId = document.querySelector("#confirm-modal").getAttribute("card-project-id");

            const formData = new FormData();
            formData.append("projId", projectId);
            formData.append("action", "delete_drawing");

            fetch("./database/database.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(body => {
                    console.log(body);
                })

            sendToast();

            setTimeout(function() {
                location.reload();
            }, 500);
        }
    </script>
</body>

</html>