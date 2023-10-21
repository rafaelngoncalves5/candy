<?php
require 'src\db.php';

/*
$result = $db->query('SELECT * FROM users');
echo print_r($result->fetch_all(MYSQLI_ASSOC));
*/

class FormValidator
{

    // Username validation
    static function validate_username(string $username): string
    {
        if (isset($_POST['username'])) {
            return "Erro: nome de usuário inválido!";
        } else {
            // Based on: ^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$
            // Once again, thanks to: https://regexr.com
            $username_regex = "/^(?=.*?[a-z])(?=.*?[0-9])(?!.*?[A-Z])(?!.*?[#?!@$ %^&*-])/";
            if (preg_match($username_regex, $username)) {
                // Next
                // Valida no BD
                #...
                global $db;
                // Armazenando os dados na array result
                // 1 - Prepara a query com o placeholder ?
                $stmt = $db->prepare("SELECT username FROM users WHERE username = ?");
                // 2 - Binda os atributos do placeholder
                $stmt->bind_param("s", $username);
                // 3 - Executa a consulta
                $stmt->execute();

                // 4 - Armazena os valores numa variável
                $result = $stmt->get_result();
                // 5 - Dá fetch no $result
                # $tables = $result->fetch_assoc();
                
                return $result->num_rows >= 1 ? "\nErro: usuário já existe!" : $username;

            } else {

                return

                    /*
                        Obs: numa aplicação em produção, seria interessante
                        tratar os erros um a um, mas como não é o caso, usarei
                        apenas uma string com o caso geral!
                    */
                    "
                    Erro: formato inválido, seu nome de usuário precisa de: \n\n
                     - Pelo menos 1 letra minúscula
                     - Pelo menos 1 número
                     - Não pode ter símbolos especiais (#?!@$ %^&*-)
                     - Não podem ter espaços
                     - Não podem ter letras maiúsculas
                    ";
            }
        }
    }

    // Email validation
    static function validate_email(string $email, string $confirm_email): string
    {
        if (isset($email)) {
            // Next
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                // Next
                if ($email === $confirm_email) {

                    // Next
                    // Existe no bd?
                    
                    // 1 - Prepara uma consulta
                    global $db;
                    $stmt = $db->prepare("SELECT email FROM users WHERE email = ?");

                    // 2 - Binda os valores
                    $stmt->bind_param("s", $email);

                    // 3 - Executa a query
                    $stmt->execute();

                    // 4 - Armazena o resultado
                    $result = $stmt->get_result();
                    
                    return $result->num_rows >= 1? "Erro: email já existe!" : $email;
                    
                } else {
                    return "Erro: Os emails não são iguais!";
                }

            } else {
                return "Erro: email inválido!";
            }
        } else {
            return "Erro: email inválido!";
        }
    }

    // Password validation
    // Receives a password, validates it, and returns a hash
    static function validate_password(string $password, string $confirm_password): string
    {
        // Created with the marvelous help of: https://regexr.com/
        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/";

        if (isset($password)) {

            // Next
            if (strlen($password) <= 6) {
                return "Erro: sua senha é muito curta!";
            } else {
                //Next
                if (preg_match($password_regex, $password)) {
                    // Next
                    if ($password === $confirm_password) {

                        // Hash that
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        // Verifies hashed version with -> password_verify($password, $hash)
                        # return password_verify($password, $hash) ? ":)" : ";(";

                        return $hash;
                    } else {
                        return "Erro: as senhas precisam ser iguais!";
                    }

                } else {
                    echo preg_match($password_regex, $password);
                    /*
                    Obs: numa aplicação em produção, seria interessante
                    tratar os erros um a um, mas como não é o caso, usarei
                    apenas uma string com o caso geral!
                    */
                    return
                        "
                    Erro: formato inválido, sua senha precisa de: \n\n
                     - Pelo menos 1 caracter minúsculo\n 
                     - Pelo menos 1 caracter maiúsculo\n
                     - Pelo menos 1 número\n
                     - Pelo menos 8 caracteres\n";
                }

            }

        } else {
            return "Erro: senha inválida";
        }
    }
}

// Testando email
#echo FormValidator::validate_email("rafaelngoncalves5@outlook.com", "rafaelngoncalves5@outlook.com");

// Testando senha
#echo FormValidator::validate_password("null123456A", "null123456A");

// Testando username
#echo FormValidator::validate_username("rafaeln5");

?>