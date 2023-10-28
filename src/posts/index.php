<?php

require '../db.php';

// Safe query
$posts = $db->query('SELECT * FROM posts ORDER BY -created_at')->fetch_all(MYSQLI_ASSOC);

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
                    if ($key == "title") printf("<li><strong>%s - <span style='color: var(--php-dark);'>%s</span></strong></li>", ucfirst($key), $value);
                    if ($key == "user_id") {
                        $user_email = $db->query("SELECT email FROM users WHERE id = '{$value}'")->fetch_column(0);
                        echo "<li><strong>Posted by - </strong>$user_email</li>";
                    };
                    if ($key == "body") echo "<label><strong>Body - </strong></label><textarea readonly>$value</textarea>";
                    if ($key == "created_at") echo "<li><strong>Created at - </strong>$value</li>";
                    if ($key == "likes_counter") echo "<li><strong>💗$value</strong></li>";
                    # printf("<li><strong>%s - </strong>%s</li>", ucfirst($key), $value); ?>
                <?php endforeach; ?>
                <!-- Buttons -->
                

                <?= "</ul>"; ?>
            <?php endforeach; ?>

        </div>

    </main>

</body>

</html>