<?php
include '../../includes/conexao.php';

$sql = "SELECT * FROM engenheiros";
$result = $conn->query($sql);

$engenheiros = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $engenheiros[] = $row;
    }
    echo json_encode(['status' => 'success', 'engenheiros' => $engenheiros]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nenhum engenheiro encontrado']);
}

$conn->close();
