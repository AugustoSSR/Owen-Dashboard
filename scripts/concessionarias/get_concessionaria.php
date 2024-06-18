<?php
include '../../includes/conexao.php';

$id = $_GET['id'];

$sql = "SELECT * FROM concessionarias WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $concessionaria = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'concessionaria' => $concessionaria]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Concessionária não encontrada']);
}

$conn->close();
