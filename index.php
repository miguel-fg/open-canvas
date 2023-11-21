<?php

include "./templates/canvas.php";
include "./templates/tools.php";

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
        <h1>Open Canvas</h1>
        <p>Your Free Space for Art</p>
        <div class="parent">
            <div class="div1">
                <?php get_canvas() ?>
            </div>
            <div class="div2">
                <?php get_tool_ribbon() ?>
            </div>
            <div class="div3"> </div>
        </div>
    </body>
</html>
