<?php
include '../../includes/conexao.php';

$id = $_POST['id'];
$nome = $_POST['nome'];

$sql = "UPDATE empresas SET nome = '$nome' WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Empresa atualizada com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar empresa']);
}

$conn->close();
