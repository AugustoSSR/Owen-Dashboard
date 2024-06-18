<?php
include '../../includes/conexao.php';

$sql = "SELECT * FROM concessionarias";
$result = $conn->query($sql);

$concessionarias = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $concessionarias[] = $row;
    }
    echo json_encode(['status' => 'success', 'concessionarias' => $concessionarias]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nenhuma concessionária encontrada']);
}

$conn->close();
