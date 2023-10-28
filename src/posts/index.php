<?php

require '../db.php';

// Safe query
$posts = $db->query('SELECT * FROM posts ORDER BY created_at')->fetch_all(MYSQLI_ASSOC);

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
                    echo "<li><strong>$key</strong> - $value</li>"; ?>
                <?php endforeach; ?>
                <?= "</ul>"; ?>
            <?php endforeach; ?>

        </div>

    </main>

</body>

</html>