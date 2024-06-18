<?php
include '../../includes/conexao.php';

$id = $_POST['id'];

$sql = "DELETE FROM engenheiros WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Engenheiro deletado com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar engenheiro']);
}

$conn->close();
