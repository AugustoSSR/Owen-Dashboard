<?php
include '../../includes/conexao.php';

$id = $_POST['id'];

$sql = "DELETE FROM empresas WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Empresa deletada com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar empresa']);
}

$conn->close();
