<?php

require '../db.php';

$username = "";

session_start();

// Protected route script:
if (isset($_SESSION) && isset($_SESSION["username"]) && $_SESSION['is_logged']) {
    $username = $_SESSION['username'];
} else {
    header('location:../auth/login.php');
}

// Formulary variables
$title = "";
$body = '';

// Prosseguimos com o post:
#...

?>

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

            <p>Create a new post:</p>

        </div>

        <!-- Form -->
        <form action='create.php' method='post'>

            <!-- Title -->
            <label for='title'>Title:</label>
            <input name='title' value='<?=$title;?>' id='title'></input>

            <!-- Body -->
            <label for='body'>Body:</label>
            <input name='body' value='<?=$body;?>' id='body'></input>

            <!-- Created at is defined in the db's instance by default with 'now()' -->
            
            <!-- User id comes from session -->

            <!-- Liked is defined in the db's instance by default with '0' -->

            <button type='submit' class='primary-btn'>Submit</button>

        </form> 

        <h1>
            <?= print_r($_REQUEST);?>
        </h1>


    </main>

</body>

</html>