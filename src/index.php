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

?>

<!DOCTYPE html>

<head>

    <!-- Meta tags do HTML -->
    <meta charset="UTF-8">
    <meta name="description" content="PHP stuff">
    <meta name="keywords" content="PHP stuff">
    <meta name="author" content="Rafael N">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Candy - Behold PHP!</title>
</head>

<html>

<body>
    <h1>Olá mundo, eu sou o
        <?= "<strong style='color: #777BB3'>PHP!</strong>"; ?>
    </h1>

    <!-- Aqui vem os formulários, amigo -->
    ...
</body>

</html>