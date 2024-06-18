<?php
include '../../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $userId = $_GET["id"];

    // Verifica se o usuário tem uma senha definida
    $sql_check_password = "SELECT password FROM users WHERE id = ?";
    $stmt_check_password = $conn->prepare($sql_check_password);
    $stmt_check_password->bind_param("i", $userId);
    $stmt_check_password->execute();
    $result_check_password = $stmt_check_password->get_result();

    if ($result_check_password->num_rows > 0) {
        $row = $result_check_password->fetch_assoc();
        if (empty($row['password'])) {
            echo json_encode(["status" => "error", "message" => "Usuário não pode ser ativado. Defina uma senha primeiro."]);
        } else {
            // Alterna o status de ativação do usuário
            $sql_toggle = "UPDATE users SET is_active = NOT is_active WHERE id = ?";
            $stmt_toggle = $conn->prepare($sql_toggle);
            $stmt_toggle->bind_param("i", $userId);
            if ($stmt_toggle->execute()) {
                echo json_encode(["status" => "success", "message" => "Status do usuário alterado com sucesso."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Erro ao alterar status do usuário."]);
            }
            $stmt_toggle->close();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Usuário não encontrado."]);
    }

    $stmt_check_password->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Requisição inválida."]);
}
