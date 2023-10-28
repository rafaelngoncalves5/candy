<?php

require '../db.php';
require '../vs.php';

$post_id = 0;

// Safe query
$posts = $db->query('SELECT * FROM posts ORDER BY -created_at')->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = verify_session();
    $post_id = $_POST['post_id'];

    if (isset($_SESSION)) {
        $user_id = $db->query("SELECT id FROM users WHERE username = '{$username}'")->fetch_column(0);

        // Cria uma nova tabela users_posts
        $db->query("INSERT INTO users_posts(user_id, post_id) VALUES ($user_id, $post_id)");
        // Incrementa o contador do post em questão
        $db->query("UPDATE posts SET likes_counter = likes_counter + 1 WHERE id = $post_id");
        
        $post_id = 0;
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
    <link rel="stylesheet" href="../styles/globals.css" />

    <title>Candy - Posts</title>
</head>

<html>

<body>
    <main>
        <div class="header">
            <h1>BEHOLD THE MIGHTY</h1>

            <?= "<h2 class='title' style='color: var(--php-dark)'><a href='/'>PHP!</a></h2>"; ?>

            <p>Feed of posts:</p>
        </div>

        <!-- Insert here all db's posts ordered by time() -->
        <div>
            <?php foreach ($posts as $post):
                # Início da tag
                echo "<ul>";
                foreach ($post as $key => $value):
                    // Formatando
                    if ($key == "title")
                        printf("<li><strong>%s - <span style='color: var(--php-dark);'>%s</span></strong></li>", ucfirst($key), $value);
                    if ($key == "user_id") {
                        $user_email = $db->query("SELECT email FROM users WHERE id = '{$value}'")->fetch_column(0);
                        echo "<li><strong>Posted by - </strong>$user_email</li>";
                    }
                    ;
                    if ($key == "body")
                        echo "<label><strong>Body - </strong></label><textarea readonly>$value</textarea>";
                    if ($key == "created_at")
                        echo "<li><strong>Created at - </strong>$value</li>";
                    if ($key == "likes_counter") {
                        echo
                            "<li><form style='border:none;padding:none;box-shadow:none;' method='post' action='./index.php'><input type='hidden' name='post_id' value={$post['id']}></input><strong><button type='submit' style='background: none;
                            color: inherit;
                            border: none;
                            padding: 0;
                            font: inherit;
                            cursor: pointer;
                            outline: inherit;'>💗$value</strong></button></form></li>";
                    }
                    # printf("<li><strong>%s - </strong>%s</li>", ucfirst($key), $value); ?>
                <?php endforeach; ?>

                <?= "</ul>"; ?>
            <?php endforeach; ?>

        </div>

        <?= "<h1>O post_id está em => $post_id</h1>"; ?>

    </main>

</body>

</html>