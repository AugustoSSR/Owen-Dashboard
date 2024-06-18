<?php
include '../../includes/conexao.php';

$response = array();

if (isset($_POST['id']) && isset($_POST['nome'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];

    $sql = "UPDATE cidades SET nome = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $nome, $id);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Cidade atualizada com sucesso';
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
    $response['message'] = 'ID ou nome não fornecido';
}

echo json_encode($response);
$conn->close();
