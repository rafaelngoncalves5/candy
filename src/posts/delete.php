<?php
require '../db.php';
require '../vs.php';

$username = verify_session();

$user_id = $db->query("SELECT id FROM users WHERE username = '{$username}'")->fetch_column(0);

// Safe query
$posts = $db->query("SELECT * FROM posts WHERE user_id = $user_id ORDER BY -created_at")->fetch_all(MYSQLI_ASSOC);

if (isset($_SESSION)) {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if ($_GET['user_id'] === $user_id) {

            // Como sou burro e esqueci de colocar ON CASCADE na modelagem:
            $query = $db->prepare("DELETE FROM users_posts WHERE post_id = ?");
            $query->bind_param('s', $_GET['post_id']);
            $query->execute();

            $query = $db->prepare("DELETE FROM posts WHERE id = ?");
            $query->bind_param("s", $_GET['post_id']);
            $query->execute();

            /*
            $db->query("DELETE FROM users_posts WHERE post_id = {$_GET['post_id']}");
            $db->query("DELETE FROM posts WHERE id = {$_GET['post_id']}");
            */

            header('location:./my-posts.php');
        } else {
            header('location:../auth/login.php');
        }
    } else {
        header('location:../auth/register.php');
    }
}

; ?>