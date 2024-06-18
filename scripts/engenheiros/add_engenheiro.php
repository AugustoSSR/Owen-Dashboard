<?php
include '../../includes/conexao.php';

$nome = $_POST['nome'];

$sql = "INSERT INTO engenheiros (nome) VALUES ('$nome')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Engenheiro adicionado com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar engenheiro']);
}

$conn->close();
