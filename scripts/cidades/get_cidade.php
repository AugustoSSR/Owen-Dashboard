<?php
include '../../includes/conexao.php';

$sql = "SELECT * FROM cidades";
$result = $conn->query($sql);

$cidades = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cidades[] = $row;
    }
    echo json_encode(['status' => 'success', 'cidades' => $cidades]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nenhuma cidade encontrada']);
}

$conn->close();
