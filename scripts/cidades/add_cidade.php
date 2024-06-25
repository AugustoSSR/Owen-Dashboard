<?php
include '../../includes/conexao.php';

$nome = $_POST['nome'];

$sql = "INSERT INTO cidades (nome) VALUES ('$nome')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Empresa adicionada com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar empresa']);
}

$conn->close();
