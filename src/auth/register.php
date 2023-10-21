<?php
include '../db.php';

$username = null;
$email = null;
$confirm_email = null;
$password = null;
$confirm_password = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = preg_replace("[\s\S]","", $_POST["username"]);
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

    <title>Candy - Register</title>
</head>

<html>

<body>
    <main>
        <div class="header">
            <h1>BEHOLD THE MIGHTY</h1>

            <?= "<h2 class='title' style='color: var(--php-dark)'>PHP!</h2>"; ?>

            <p>Register a new user:</p>
        </div>

        </ul>

        <!-- Form -->
        <form method="post" action="register.php">

            <!-- Email -->
            <label for="username">Username:</label>
            <input name="username" id="username" value="<?php echo $username; ?>"></input>

            <button type="submit" class="primary-btn">Submit</button>

        </form>

        <p>
            Received data -> <?=print_r($_POST);?>

            Username -> <?=$username;?>
        </p>

    </main>

</body>

</html>