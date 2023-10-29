<?php

require '../db.php';
require '../vs.php';

$username = verify_session();

$user_id = $db->query("SELECT id FROM users WHERE username = '{$username}'")->fetch_column(0);

// Safe query
$posts = $db->query("SELECT * FROM posts WHERE user_id = $user_id ORDER BY -created_at")->fetch_all(MYSQLI_ASSOC);

if (isset($_SESSION) && !empty($_SESSION)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

       $query = $db->prepare('UPDATE posts SET title=?, body=? WHERE id = ?');
       $query->bind_param('sss', $_POST['title'], $_POST['body'], $_POST['post_id']);
       $query->execute();

        // Necessário dar reload para limpar os dados de formulário
        header('location:./my-posts.php');
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

            <p>My posts:</p>
        </div>

        <!-- Insert here all db's posts ordered by time() -->
        <div>
            <?php foreach ($posts as $post):
                # Início da tag
                echo "<ul>";
                echo "<form method='post' action='./my-posts.php' style='border: 0; padding: 0; box-shadow: none; margin: 0;'>";

                foreach ($post as $key => $value):
                    if ($key === 'id')
                        echo "<input type='hidden' name='post_id' value='$value'}'></input>";
                    // Para cada post, um formulário
                    if ($key == "title")
                        echo "<label for='title'><strong>Title - </strong><input id='title' name='title' value='$value'></input></label>";

                    if ($key == "body")
                        echo "<label for='body'><strong>Body - </strong></label><textarea name='body' id='body'>$value</textarea>";

                    if ($key == "likes_counter") {
                        echo
                            "<li>💗$value</strong></li>";
                    }

                    # printf("<li><strong>%s - </strong>%s</li>", ucfirst($key), $value); ?>
                <?php endforeach; ?>

                <?= "<button class='primary-btn' type='submit'>Submit</button>"; ?>
                <?= "</form>"; ?>
                <?= "</ul>"; ?>

            <?php endforeach; ?>

        </div>

    </main>

</body>

</html>