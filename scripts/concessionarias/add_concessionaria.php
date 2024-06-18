<?php
include '../../includes/conexao.php';

$nome = $_POST['nome'];

$sql = "INSERT INTO concessionarias (nome) VALUES ('$nome')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Concessionária adicionada com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar concessionária']);
}

$conn->close();
