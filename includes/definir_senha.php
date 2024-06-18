<?php
// Arquivo para definir a senha para um novo usuário
include 'conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = protect_input($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Verifica se as senhas coincidem
    if ($password === $confirm_password) {
        // Hash da senha
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Atualiza a senha no banco de dados
        $sql = "UPDATE users SET password='$hashed_password', is_active=1 WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            echo "Senha definida com sucesso!";
        } else {
            echo "Erro ao definir a senha: " . $conn->error;
        }
    } else {
        echo "As senhas não coincidem.";
    }
}

$conn->close();
