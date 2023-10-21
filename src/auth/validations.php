<?php

class FormValidator
{

    // Email validation
    static function validate_email(string $email): string
    {
        if (isset($email)) {
            // Next
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            } else {
                return "Erro: email inválido!";
            }
        } else {
            return "Erro: email inválido!";
        }
    }

    // Password validation
    // Receives a password, validates it, and returns a hash
    static function validate_password(string $password): string
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
                    // Hash that
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    // Verifies hashed version with -> password_verify($password, $hash)
                    # return password_verify($password, $hash) ? ":)" : ";(";

                    return $hash;
                }
                else {
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
# echo Validator::validate_email(null);

// Testando senha
echo Validator::validate_password("null123456A");

; ?>