<?php
include '../../includes/conexao.php';

$response = array();

try {
    // Consulta para obter o total de usuários
    $sqlTotalUsers = "SELECT COUNT(*) as total FROM users";
    $resultTotalUsers = $conn->query($sqlTotalUsers);
    if (!$resultTotalUsers) {
        throw new Exception("Erro na consulta: " . $conn->error);
    }
    $totalUsers = $resultTotalUsers->fetch_assoc()['total'];

    // Consulta para obter o número de usuários a serem ativados
    $sqlPendingUsers = "SELECT COUNT(*) as total FROM users WHERE is_active = 0";
    $resultPendingUsers = $conn->query($sqlPendingUsers);
    if (!$resultPendingUsers) {
        throw new Exception("Erro na consulta: " . $conn->error);
    }
    $pendingUsers = $resultPendingUsers->fetch_assoc()['total'];

    // Consulta para obter o número de usuários ativos
    $sqlActiveUsers = "SELECT COUNT(*) as total FROM users WHERE is_active = 1";
    $resultActiveUsers = $conn->query($sqlActiveUsers);
    if (!$resultActiveUsers) {
        throw new Exception("Erro na consulta: " . $conn->error);
    }
    $activeUsers = $resultActiveUsers->fetch_assoc()['total'];

    // Preparar a resposta
    $response['status'] = 'success';
    $response['totalUsers'] = $totalUsers;
    $response['pendingUsers'] = $pendingUsers;
    $response['activeUsers'] = $activeUsers;
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
$conn->close();
