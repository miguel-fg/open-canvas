<?php

define('DBHOST', 'localhost');
define('DBNAME', 'opencanvas');
define('DBUSER', 'root');
define('DBPASS', '');

// function router
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        switch ($action) {
            case "submit_drawing":
                submit_drawing();
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
        $pdo = db_connect();
        
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
