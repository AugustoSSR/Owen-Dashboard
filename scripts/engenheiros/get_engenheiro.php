<?php
include '../../includes/conexao.php';

$id = $_GET['id'];

$sql = "SELECT * FROM engenheiros WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $engenheiro = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'engenheiro' => $engenheiro]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Engenheiro não encontrado']);
}

$conn->close();
