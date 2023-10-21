<?php

class FormValidator
{
    static string $username_error = "";
    static string $email_error = "";
    static string $password_error = "";

    // Username validation
    static function validate_username(string $username, object $db): bool
    {
        if (strlen($username) <= 4) {
            self::$username_error = 'Erro: nome de usuário inválido!';
            return false;
        } else {
            // Based on: ^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$
            // Once again, thanks to: https://regexr.com
            $username_regex = "/^(?=.*?[a-z])(?=.*?[0-9])(?!.*?[A-Z])(?!.*?[#?!@$ %^&*-])/";
            if (preg_match($username_regex, $username)) {
                // Next
                // Valida no BD
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

                if ($result->num_rows >= 1) {
                    self::$username_error = "\nErro: usuário já existe!";
                    return false;
                }
                self::$username_error = "";
                return true;

            } else {

                self::$username_error = "
                    Erro: formato inválido, seu nome de usuário precisa de: \n\n
                     - Pelo menos 1 letra minúscula\n
                     - Pelo menos 1 número\n
                     - Não pode ter símbolos especiais (#?!@$ %^&*-)\n
                     - Não podem ter espaços\n
                     - Não podem ter letras maiúsculas\n";

                return false;

            }
        }
    }

    // Email validation
    static function validate_email(string $email, string $confirm_email, object $db): bool
    {
        if (isset($email)) {
            // Next
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                // Next
                if ($email === $confirm_email) {

                    // Next
                    // Existe no bd?

                    // 1 - Prepara uma consulta
                    $stmt = $db->prepare("SELECT email FROM users WHERE email = ?");

                    // 2 - Binda os valores
                    $stmt->bind_param("s", $email);

                    // 3 - Executa a query
                    $stmt->execute();

                    // 4 - Armazena o resultado
                    $result = $stmt->get_result();

                    self::$email_error = "Erro: email já existe!";

                    if ($result->num_rows >= 1) {
                        self::$email_error;
                        return false;
                    } else {
                        self::$email_error = "";
                        return true;
                    }

                } else {
                    self::$email_error = "Erro: Os emails não são iguais!";
                    return false;
                }

            } else {
                self::$email_error = "Erro: email inválido!";
                return false;
            }
        } else {
            self::$email_error = "Erro: email inválido!";
            return false;
        }
    }

    // Password validation
    // Receives a password, validates it, and returns a hash
    static function validate_password(string $password, string $confirm_password, object $db): bool
    {
        // Created with the marvelous help of: https://regexr.com/
        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/";

        if (isset($password)) {

            // Next
            if (strlen($password) <= 6) {
                self::$password_error = "Erro: sua senha é muito curta!";
                return false;
            } else {
                //Next
                if (preg_match($password_regex, $password)) {
                    // Next
                    if ($password === $confirm_password) {

                        // Hash that
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        // Verifies hashed version with -> password_verify($password, $hash)
                        # return password_verify($password, $hash) ? ":)" : ";(";

                        // Cleans error message
                        self::$password_error = "";
                        return true;

                    } else {
                        self::$password_error = "Erro: as senhas precisam ser iguais!";
                        return false;
                    }

                } else {
                    echo preg_match($password_regex, $password);
                    /*
                    Obs: numa aplicação em produção, seria interessante
                    tratar os erros um a um, mas como não é o caso, usarei
                    apenas uma string com o caso geral!
                    */
                    self::$password_error = "
                    Erro: formato inválido, sua senha precisa de: \n\n
                     - Pelo menos 1 caracter minúsculo\n 
                     - Pelo menos 1 caracter maiúsculo\n
                     - Pelo menos 1 número\n
                     - Pelo menos 8 caracteres\n";
                    return false;
                }

            }

        } else {
            self::$password_error = "Erro: senha inválida";
            return false;
        }
    }

    // Este método verifica se todas as funções estão corretas e envia os dados ao BD
    static function all_valid(bool $password_ops, bool $email_ops, bool $username_ops)
    {
        if ($password_ops && $email_ops && $username_ops) {
            return true;
        }
        return false;
    }
}

// Testando email
#echo FormValidator::validate_email("rafaelngoncalves5@outlook.com", "rafaelngoncalves5@outlook.com");

// Testando senha
#echo FormValidator::validate_password("null123456A", "null123456A");

// Testando username
#echo FormValidator::validate_username("rafaeln5");

?>