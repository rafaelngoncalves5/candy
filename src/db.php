<?php

// echo "\n\n === MySQL " . date("Y/m/d") . " === \n\n";

# Database variables
$hostname = "localhost";
$user = "root";
$password = "birdscooter123"; // Would be safer to set it in php.ini tho
$database = "database_name";

$db = new mysqli($hostname, $user, $password, $database);

if ($db->connect_errno) {
    echo "<!-- Oops... Tivemos um erro ao tentar nos conectar ao MySQL! Erro -> $db->connect_error -->";
    exit();
}
echo "<!-- Conectado com sucesso no MySQL! -->";

/*

Fazendo alguns testes:

// Inserindo dados
$db->query(
    "INSERT INTO users (username, email, password) 
    VALUES ('rafaeln5', 'rafaelngoncalves5@outlook.com', '12345678')"
);

// Retornando tabelas
$result = $db->query("SELECT * FROM users");

echo print_r($result->fetch_all()); // Só checando os dados para inserção

echo count((array) $result);

*/

$db->close();

?>