<?php
include '../../includes/conexao.php';

$id = $_GET['id'];

$sql = "
SELECT 
    servicos.id, 
    servicos.nome_projeto, 
    cidades.nome AS cidade, 
    empresas.nome AS empresa, 
    concessionarias.nome AS concessionaria, 
    servicos.metragem_total, 
    servicos.quantidade_postes, 
    servicos.numero_art, 
    engenheiros.nome AS engenheiro, 
    servicos.responsavel_empresa, 
    servicos.responsavel_comercial
FROM servicos
JOIN cidades ON servicos.cidade_id = cidades.id
JOIN empresas ON servicos.empresa_id = empresas.id
JOIN concessionarias ON servicos.concessionaria_id = concessionarias.id
JOIN engenheiros ON servicos.engenheiro_id = engenheiros.id
WHERE servicos.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $service = $result->fetch_assoc();
    echo json_encode(["status" => "success", "servico" => $service]);
} else {
    echo json_encode(["status" => "error", "message" => "Serviço não encontrado"]);
}
