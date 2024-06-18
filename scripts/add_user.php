<?php
session_start();
include '../includes/conexao.php';

header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Usuário não autenticado."]);
    exit();
}

// Função para proteger os dados de entrada
function protect_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Processa o formulário de adicionar usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = protect_input($_POST["name"]);
    $email = protect_input($_POST["email"]);

    // Verifica se o usuário já existe
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (empty($row["password"])) {
            // O usuário existe mas não possui senha definida
            echo json_encode(["status" => "error", "message" => "Usuário já existe mas não possui senha definida."]);
        } else {
            // O usuário já possui senha definida
            echo json_encode(["status" => "error", "message" => "Usuário já existe."]);
        }
    } else {
        // Insere o novo usuário no banco de dados
        $sql_insert = "INSERT INTO users (name, email, is_active) VALUES (?, ?, 0)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $name, $email);
        if ($stmt_insert->execute()) {
            echo json_encode(["status" => "success", "message" => "Usuário criado com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao adicionar usuário: " . $stmt_insert->error]);
        }
        $stmt_insert->close();
    }

    $stmt->close();
    $conn->close();
}
