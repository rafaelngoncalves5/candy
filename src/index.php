<?php

/*
Observações:

- Tive problemas em entender o funcionamento do .ini do PHP. Passei uns dois dias
tentando entender a razão pela qual o PHP não vinha com um package manager por padrão
(tive que instalar o composer depois). Mas agora entendi meu erro: estava tentando usar
o PDO e o MySQLi através dos "uncomments" no php.ini, no entanto, era o errado (kk).

- Estou rodando o servidor built-in do PHP usando: php -S localhost:3000 -t src! 
Xampp não faz sentido.
*/

// Sumonando o banco de dados antes de qualquer coisa
include 'db.php';
include 'vs.php';

session_start();

// Condicional padrão, pra deslogar usuário a cada 1 hora
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    session_unset();
    session_destroy();
} else {
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Se fizermos um método post pra essa página (no caso logout é o único aceito), finalizamos a sessão de usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_SESSION) && $_SESSION['is_logged']) {
        session_unset();
        session_destroy();
    }
}

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
    <link rel="stylesheet" href="./styles/globals.css" />

    <title>Candy - Behold PHP!</title>
</head>

<html>

<body>
    <main>
        <div class="header">
            <h1>BEHOLD THE MIGHTY</h1>

            <?= "<h2 class='title' style='color: var(--php-dark)'><a href='/'>PHP!</a></h2>"; ?>

            <!-- Session stuff -->
            <?php
            // Se o usuário estiver logado:
            if (!empty($_SESSION['username']) && $_SESSION['is_logged']) {
                echo "<p>Olá {$_SESSION['username']}</p>";
                echo "<form style='background: none; box-shadow: none; max-width: fit-content;border: none; color: none;' method='post' action='index.php'><button class='primary-btn' type='submit' name='logout'>Logout</button></form>";
            }
            ?>

            <p>List of pages:</p>
        </div>

        <ul>
            <li>
                <a href="./auth/register.php">Register -> Register a new user <strong>(FR-01)</strong></a>
            </li>

            <li>
                <a href="./auth/login.php">Register -> Login an user <strong>(FR-02)</strong></a>
            </li>

            <li>
                <a href="./posts/index.php">Posts (index) -> Index of the posts with a feed of them
                    <strong>(RF-09)</strong></a>
            </li>

            <li>
                <a href="./posts/create.php">Posts (creation) -> Form to create the posts <strong>[PROTECTED]
                        (RF-04)</strong></a>
            </li>

            <li>
                <a href="./posts/my-posts.php">My Posts (update and deletion) -> Updates and deletes your posts
                    <strong>[PROTECTED] (RF-05, RF-07)</strong></a>
            </li>

            <li>
                <a href="./posts/upload-handler.php">File upload -> Uploads an image
                    <strong>[PROTECTED] RF-10)</strong></a>
            </li>

            <?php
            $username = verify_session();

            if (isset($_SESSION) && isset($username)) {
                $query = $db->prepare('SELECT is_admin FROM users WHERE username = ?');
                $query->bind_param('s', $username);
                $query->execute();
                $is_admin = $query->get_result()->fetch_column(0);
                
                // Se o usuário for admin
                if ($is_admin == 1) {
                    echo "<li><a href='./admin.php'>Edit an user -> <strong>[PROTECTED][ADMIN] (RF-08)</strong></a></li>";
                }
            }
            ;?>

            <hr />

        </ul>
    </main>

</body>

</html>