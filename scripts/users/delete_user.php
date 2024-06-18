<?php
header('Content-Type: application/json');
session_start();
include '../../includes/conexao.php';

// Manipulador de erros global
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Erro no servidor: $errstr em $errfile na linha $errline"
    ]);
    exit();
});

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Usuário não está logado."]);
    exit();
}

// Função para proteger os dados de entrada
function protect_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Processa a solicitação para deletar o usuário
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $userId = protect_input($_GET["id"]);

        // Verifica se o usuário existe
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Deleta o usuário
            $sql_delete = "DELETE FROM users WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $userId);

            if ($stmt_delete->execute()) {
                echo json_encode(["status" => "success", "message" => "Usuário deletado com sucesso."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Erro ao deletar usuário: " . $stmt_delete->error]);
            }
            $stmt_delete->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Usuário não encontrado."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "ID do usuário não fornecido."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de solicitação inválido."]);
}

$conn->close();
