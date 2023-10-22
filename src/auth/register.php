<?php
include '../db.php';
include './validations.php';

$username = null;
$email = null;
$confirm_email = null;
$password = null;
$confirm_password = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar tudo, enviar pro BD e redirecionar para a página de sucesso
    $username = preg_replace("[\s\S]", "", $_POST["username"]);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_email = $_POST['confirm_email'];
    $confirm_password = $_POST['confirm_password'];

    // Validates data on post type submit
    $email_ops = FormValidator::validate_email($email, $confirm_email, $db);
    $username_ops = FormValidator::validate_username($username, $db);
    $password_ops = FormValidator::validate_password($password, $confirm_password, $db);

    // Verifica se está tudo validado
    $is_valid = FormValidator::all_valid($email_ops, $username_ops, $password_ops);

    // Se estiver tudo ok:
    if ($is_valid) {
        // Execute suas queries aqui!
        $query = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $username, $email, $password);
        $query->execute();

        echo "User $username created with success! Redirecting...";

        // Por fim, redirecione o usuário
        header("Location: login.php");
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

            <!-- Username -->
            <label for="username">Username:</label>
            <input value="<?php echo $username;?>" name="username" id="username" value="<?php echo $username; ?>"></input>
            <span class="error-msg"><?=FormValidator::$username_error;?></span>

            <!-- Email -->
            <label for="email">Email:</label>
            <input required value="<?php echo $email;?>" name="email" id="email" type="email"></input>
            <span class="error-msg"><?=FormValidator::$email_error;?></span>

            <!-- Confirm Email -->
            <label for="confirm-email">Confirm email:</label>
            <input required value="<?php echo $confirm_email;?>" name="confirm_email" id="confirm-email" type="email"></input>

            <!-- Password -->
            <label for="password">Password:</label>
            <input value="<?php $password;?>" name="password" id="password" type="password"></input>
            <span class="error-msg"><?=FormValidator::$password_error;?></span>

            <!-- Confirm password -->
            <label for="confirm-password">Confirm password:</label>
            <input value="<?php echo $confirm_password;?>" name="confirm_password" id="password" type="password"></input>

            <button type="submit" class="primary-btn">Submit</button>

        </form>

        <p>
            Received data ->
            <?= print_r($_POST); ?>
        </p>
        <h1>
            <?=$is_valid;?>
        </h1>
    </main>

</body>

</html>