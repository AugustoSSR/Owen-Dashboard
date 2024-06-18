<?php
include '../../includes/conexao.php';

// Consulta para buscar os serviços e incluir os nomes das entidades relacionadas
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
JOIN engenheiros ON servicos.engenheiro_id = engenheiros.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
    echo json_encode(["status" => "success", "services" => $services]);
} else {
    echo json_encode(["status" => "error", "message" => "Nenhum serviço encontrado"]);
}
