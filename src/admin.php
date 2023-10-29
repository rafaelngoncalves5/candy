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

$username = verify_session();
$user_id = $db->query("SELECT id FROM users WHERE username = '{$username}'")->fetch_row()[0];

// Se fizermos um método post pra essa página (no caso logout é o único aceito), finalizamos a sessão de usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION) && isset($username)) {
        $query = $db->prepare('SELECT is_admin FROM users WHERE username = ?');
        $query->bind_param('s', $username);
        $query->execute();
        $is_admin = $query->get_result()->fetch_column(0);

        // Se o usuário for admin
        if ($is_admin == 1) {
            if ($_POST['is_admin'] == 'true') {
                $num = 1;
                $query = $db->prepare('UPDATE users SET is_admin = ? WHERE id = ?');
                $query->bind_param('ii', $num, $_POST['user_id']);
                $query->execute();
                header('location:./admin.php');

            } else {
                $num = 0;
                $query = $db->prepare('UPDATE users SET is_admin = ? WHERE id = ?');
                $query->bind_param('ii', $num, $_POST['user_id']);
                $query->execute();
                header('location:./admin.php');
            }
        } else {
            echo "Not found!";
            return http_response_code(404);
        }
    } else {
        echo "Not found!";
        return http_response_code(404);
    }
} else {
    $query = $db->prepare('SELECT is_admin FROM users WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $is_admin = $query->get_result()->fetch_column(0);

    // Redirects to oblivion
    $is_admin != 1 ? header('location:404.php') : ""; 
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

    <title>Candy - Administration</title>
</head>

<html>

<body>
    <main>
        <div class="header">
            <h1>BEHOLD THE MIGHTY</h1>

            <?= "<h2 class='title' style='color: var(--php-dark)'><a href='/'>PHP!</a></h2>"; ?>

            <p>Edit users:</p>
        </div>

        <?php

        $query = $db->prepare("SELECT * FROM users WHERE id != ?");
        $query->bind_param('i', $user_id);
        $query->execute();
        $users = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($users as $user):
            echo "<ul>";
            foreach ($user as $key => $value) {
                if ($key === 'id')
                    echo "<li><strong>Id - </strong>$value</li>";
                if ($key === 'username')
                    echo "<li><strong>Username - </strong>$value</li>";
                if ($key === 'email')
                    echo "<li><strong>Email - </strong>$value</li>";
                if ($key === 'created_at')
                    echo "<li><strong>Creation date - </strong>$value</li>";
                if ($key === 'is_admin') {
                    echo $value == 1 ? "<strong style='margin:1.5rem 0;color:royalblue;'>Admin</strong>" : "<strong style='margin:1.5rem 0;color:royalblue;'>Not admin</strong>";
                    echo "<form method='post' action='./admin.php' style='boder: 0;background-color:snow;padding:2rem; margin:0; '><h4>Is admin?</h4><label style='font-size:medium;' for='true'>Yes</label><input type='radio' name='is_admin' value='true'></input><label style='font-size:medium;' for='false'>No</label><input type='radio' name='is_admin' value='false'></input><button type='submit' class='primary-btn'>Submit</button><input type='hidden' name='user_id' value='{$user['id']}'></input></form>";
                }
            }


            echo "</ul>";

            ; ?>
        <?php endforeach; ?>

        </ul>
    </main>

</body>

</html>