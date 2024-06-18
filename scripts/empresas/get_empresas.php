<?php
include '../../includes/conexao.php';

$sql = "SELECT * FROM empresas";
$result = $conn->query($sql);

$empresas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empresas[] = $row;
    }
    echo json_encode(['status' => 'success', 'empresas' => $empresas]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nenhuma empresa encontrada']);
}

$conn->close();
