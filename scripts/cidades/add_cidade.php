<?php
include '../../includes/conexao.php';

$response = array();

if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];

    $sql = "INSERT INTO cidades (nome) VALUES (?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $nome);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Cidade adicionada com sucesso';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao executar a consulta';
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Erro na preparação da consulta';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Nome não fornecido';
}

echo json_encode($response);
$conn->close();
