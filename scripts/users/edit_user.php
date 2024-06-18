<?php
include '../../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $userId = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $email, $userId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Usuário atualizado com sucesso."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao atualizar usuário."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Requisição inválida."]);
}
