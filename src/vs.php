<?php
function verify_session(): mixed
{

    session_start();

    // Protected route script:
    if (isset($_SESSION) && isset($_SESSION["username"]) && $_SESSION['is_logged']) {
        $username = $_SESSION['username'];
        return $username;
    } else {
        // Be careful with that
        header('location:../auth/login.php');
        return false;
    }
}
?>