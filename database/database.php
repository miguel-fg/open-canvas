<?php

define('DBHOST', 'localhost');
define('DBNAME', 'opencanvas');
define('DBUSER', 'root');
define('DBPASS', '');

$pdo = db_connect();
// function router
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        switch ($action) {
            case "submit_drawing":
                submit_drawing();
                break;
            case "delete_drawing":
                delete_drawing();
                break;
            case "update_drawing":
                update_drawing();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    }
}

function db_connect()
{
    $server = constant("DBHOST");
    $user = constant("DBUSER");
    $pw = constant("DBPASS");
    $name = constant("DBNAME");

    try {
        $pdo = new PDO("mysql:host=$server;dbname=$name", $user, $pw);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $err) {
        die($err->getMessage());
    }
}

function generate_img_filename($extension = "png")
{
    return 'oc_' . uniqid() . '.' . $extension;
}

function submit_drawing()
{
    global $pdo;

    if (isset($_POST["title"]) && isset($_POST["description"])) {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $imgDataURL = $_POST["imgURL"];

        // convert data url to image and save the image file on the server
        $imgData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgDataURL));
        $filename = generate_img_filename();
        $filepath = "./uploads/" . $filename;

        file_put_contents($filepath, $imgData);

        // add data to DB
        $sql = 'INSERT INTO drawings (title, description, path) VALUES (:title, :description, :path)';
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':path', $filepath);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'filePath' => $filepath]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving to database: ' . $stmt->errorInfo()[2]]);
        }
    } else {
        echo
        json_encode(['success' => false, 'message' => 'Missing title, description, or image data.']);
    }
}

function get_drawings()
{
    global $pdo;

    $sql = 'SELECT * FROM drawings';
    $stmt = $pdo->query($sql);

    $galleryData = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $galleryData[] = $row;
    }

    return $galleryData;
}

function get_image_path($projectId)
{
    global $pdo;

    $sql = 'SELECT path FROM drawings WHERE id = :id';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':id', $projectId);
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $projectPath = $result["path"];

        return $projectPath;
    }
}

function delete_drawing()
{
    global $pdo;

    if (isset($_POST["projId"])) {
        $projId = $_POST["projId"];

        //delete image file from server

        $projPath = get_image_path($projId);
        if ($projPath) {
            if (file_exists($projPath)) {
                if (unlink($projPath)) {
                    echo json_encode(['success' => true, 'message' => 'Deleted file from server!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error deleting from server: ']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'File does not exist: ']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting from server: ']);
        }

        //delete item from database
        $sql = 'DELETE FROM drawings WHERE id = :id';
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $projId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Deleted item from database!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting from database: ' . $stmt->errorInfo()[2]]);
        }
    }
}

function update_drawing()
{
    global $pdo;

    if (isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["description"])) {
        $projectId = $_POST["id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $imgDataURL = $_POST["imgURL"];

        // delete current image file from server
        $currentImg = get_image_path($projectId);
        unlink($currentImg);

        //generate new image and save to server
        $imgData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgDataURL));
        $filename = generate_img_filename();
        $filepath = "./uploads/" . $filename;

        file_put_contents($filepath, $imgData);

        // update data in DB
        $sql = 'UPDATE drawings SET title = :title, description = :description, path = :path WHERE id = :id';
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $projectId);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':path', $filepath);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'filePath' => $filepath]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating database: ' . $stmt->errorInfo()[2]]);
        }
    } else {
        echo
        json_encode(['success' => false, 'message' => 'Missing title, description, or image data.']);
    }
}
