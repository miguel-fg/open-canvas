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
    <!-- Nav bar -->
    <div id="sidebar" class="sidebar">
        <button class="closebtn" onclick="hideNav()">
            <img src="./icons/close-circle-svgrepo-com.svg" class="tool-icon" alt="close menu" style="width: 35px;" />
        </button>
        <a href="#" onclick="return false;" class="nav-link">Home</a>
        <a href="editor.php" class="nav-link">New Project</a>
        <a href="documentation.html" class="nav-link">Documentation</a>
    </div>
    <div class="content">
        <!-- Delete confirmation modal -->
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
            <img src="./icons/burger-menu-svgrepo-com.svg" class="tool-icon" alt="burger icon menu" style="width: 30px;" />
            <span class="menu-text">Menu</span>
        </button>
        <h1>Open Canvas</h1>
        <p>Your Free Space for Art</p>
        <!-- Gallery view -->
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
            const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            if (screenWidth < 800) {
                document.querySelector("#sidebar").style.width = "100%";
            } else {
                document.querySelector("#sidebar").style.width = "250px";
            }
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

        // Opens editor page with id on the URL
        function editProject(projectId) {
            window.location.href = 'editor.php?id=' + projectId;
        }

        function deleteProject(projectId) {
            const modal = document.querySelector("#confirm-modal");
            modal.style.display = "block"

            modal.setAttribute("card-project-id", projectId); //sets attribute to call from delete function
        }

        function cancelDelete() {
            document.querySelector("#confirm-modal").style.display = "none";
        }

        // delete post request
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