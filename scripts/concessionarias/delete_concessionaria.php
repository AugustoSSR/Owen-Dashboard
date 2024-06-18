<?php
include '../../includes/conexao.php';

$id = $_POST['id'];

$sql = "DELETE FROM concessionarias WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Concessionária deletada com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar concessionária']);
}

$conn->close();
