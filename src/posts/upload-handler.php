<?php

// Simple file handler for images using php
require '../db.php';
require '../vs.php';

$path = '../uploads/';

$username = verify_session();

// Session checks
if (isset($_SESSION)) {

    // Req checks
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES)) {
            // Pega a imagem via files:
            $image = $_FILES['picture'];

            if ($image['size'] > 900000) {
                echo 'Error: image too big!';
            }
            else {
                $file_to_upload = $path . (string)(time()) . $image['name'];
                move_uploaded_file($image['tmp_name'], $file_to_upload);
                echo basename($image['name']) . " uploaded with success!";

                // Now you could send to the db the file location and display with img src
                echo "<img src='{$file_to_upload}' alt='{$image['name']}' />";
            }
        }

    }

} else {
    header('location:../auth/login.php');
}

; ?>

<!DOCTYPE html>

<head>

    <!-- Meta tags do HTML -->
    <meta charset="UTF-8">
    <meta name="description" content="PHP stuff">
    <meta name="keywords" content="PHP stuff">
    <meta name="author" content="Rafael N">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Linking CSS -->
    <link rel="stylesheet" href="../styles/globals.css" />

    <title>Candy - Posts</title>
</head>

<html>

<body>
    <main>
        <div class="header">
            <h1>BEHOLD THE MIGHTY</h1>

            <?= "<h2 class='title' style='color: var(--php-dark)'><a href='/'>PHP!</a></h2>"; ?>

            <p>Upload images:</p>

        </div>

        <!-- Form -->
        <form enctype="multipart/form-data" action='upload-handler.php' method='post'>

            <label for='picture'>Image:</label>
            <input type='file' id='picture' name='picture'></input>

            <button type='submit' class='primary-btn'>Submit</button>

        </form>
    </main>

</body>

</html>