<?php
include '../db.php';
include './validations.php';

$username = null;
$password = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Database operations

        // 1 - Pega o usuário
        $query = $db->prepare('SELECT password FROM users WHERE username = ?');
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();
        $user_password = $result->fetch_assoc();

        // 2 - Testa se a password está correta
        if (password_verify($password, $user_password['password'])) {
            // 3 - Completar o login
            // 3.1 - Cria a session
            session_start();

            // 3.2 - Salva os dados relevantes na session
            $_SESSION['username'] = $username;
            $_SESSION['is_logged'] = true;

            // 4 - Redirecionar o usuário
            header("location:../index.php");

        } else {
            $error = "Erro: usuário ou senha incorreto(s)!";

        }

    } else {
        $error = 'Erro: usuário ou senha incorreto(s)!';
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

    <title>Candy - Login</title>
</head>

<html>

<body>
    <main>
        <div class="header">
            <h1>BEHOLD THE MIGHTY</h1>

            <?= "<h2 class='title' style='color: var(--php-dark)'><a href='/'>PHP!</a></h2>"; ?>

            <p>Login:</p>
        </div>

        </ul>

        <!-- Form -->
        <form method="post" action="login.php">

            <!-- Username -->
            <label for="username">Username:</label>
            <input value="<?php echo $username; ?>" name="username" id="username"
                value="<?php echo $username; ?>"></input>

            <!-- Password -->
            <label for="password">Password:</label>
            <input value="<?php $password; ?>" name="password" id="password" type="password"></input>

            <span class="error-msg">
                <?= $error; ?>
            </span>

            <button type="submit" class="primary-btn">Submit</button>

        </form>
    </main>

</body>

</html>