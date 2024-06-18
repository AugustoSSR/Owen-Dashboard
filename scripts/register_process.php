<?php
session_start();
include '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = protect_input($_POST["name"]);
    $email = protect_input($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Salva o email na sessão para uso posterior
        $_SESSION["email"] = $email;
        header("Location: set_password.php");
        exit();
    } else {
        $sql_insert = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql_insert) === TRUE) {
            // Retorna o usuário para a página index.php com a mensagem de registro bem-sucedido
            header("Location: ../index.php?registered=true");
            exit();
        } else {
            echo "Erro ao registrar o usuário: " . $conn->error;
        }
    }
}

$conn->close();
