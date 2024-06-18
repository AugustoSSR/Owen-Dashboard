<?php
include '../../includes/conexao.php';

$id = $_GET['id'];

$sql = "SELECT * FROM empresas WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $empresa = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'empresa' => $empresa]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Empresa não encontrada']);
}

$conn->close();
