<?php
include '../../includes/conexao.php';

$response = array();

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM cidades WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Cidade excluída com sucesso';
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
    $response['message'] = 'ID não fornecido';
}

echo json_encode($response);
$conn->close();
