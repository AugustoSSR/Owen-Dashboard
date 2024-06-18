// delete_service.php
<?php
include '../../includes/conexao.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = $data['id'];

    // Deleta o serviço do banco de dados
    $sql = "DELETE FROM servicos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao deletar serviço"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "ID não fornecido"]);
}
?>