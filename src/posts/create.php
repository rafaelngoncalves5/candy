<?php

require '../db.php';
require '../vs.php';

// Retorna falso ou um username
$username = verify_session();

// Formulary variables
$title = "";
$body = "";

// Prosseguimos com o post:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title = $_REQUEST['title'];
    $body = $_REQUEST['body'];
    
    if (isset($username) && gettype($username) === 'string') {
        // Pega o id de usuário no bd
        $user_id = $db->query("SELECT * FROM users WHERE username = '{$username}'")->fetch_column(0);
        
        // Não validarei os dados por preguiça
        $query = $db->prepare("INSERT INTO posts(title, body, user_id) VALUES (?, ?, ?)");

        $query->bind_param('sss', $title, $body, $user_id);
        $query->execute();
        // Após criar um post, redirecione para index dos posts
        header('location:./index.php');
        
    } else {
        header('location:../auth/login.php');
    }
}

;?>

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
            <input placeholder='Estou pensando em...' minlength=3 name='title' value='<?= $title; ?>'
                id='title'></input>

            <!-- Body -->
            <label for='body'>Body:</label>
            <input placeholder="Fui ao parque na semana passada, tive uma surpresa quando..." minlength=3 name='body'
                value='<?= $body; ?>' id='body'></input>

            <!-- Created at is defined in the db's instance by default with 'now()' -->

            <!-- User id comes from session -->

            <!-- Liked is defined in the db's instance by default with '0' -->

            <button type='submit' class='primary-btn'>Submit</button>

        </form>
    </main>

</body>

</html>