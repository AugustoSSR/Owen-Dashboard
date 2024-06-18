// edit_service.php
<?php
include '../../includes/conexao.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'], $data['nome_projeto'], $data['cidade'], $data['empresa'], $data['concessionaria'], $data['metragem_total'], $data['quantidade_postes'], $data['numero_art'], $data['engenheiro'], $data['responsavel_empresa'], $data['responsavel_comercial'])) {
    $id = $data['id'];
    $nomeProjeto = $data['nome_projeto'];
    $cidade = $data['cidade'];
    $empresa = $data['empresa'];
    $concessionaria = $data['concessionaria'];
    $metragemTotal = $data['metragem_total'];
    $quantidadePostes = $data['quantidade_postes'];
    $numeroART = $data['numero_art'];
    $engenheiro = $data['engenheiro'];
    $responsavelEmpresa = $data['responsavel_empresa'];
    $responsavelComercial = $data['responsavel_comercial'];

    // Atualiza o serviço no banco de dados
    $sql = "UPDATE servicos SET nome_projeto = ?, cidade = ?, empresa = ?, concessionaria = ?, metragem_total = ?, quantidade_postes = ?, numero_art = ?, engenheiro = ?, responsavel_empresa = ?, responsavel_comercial = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiiisiisi", $nomeProjeto, $cidade, $empresa, $concessionaria, $metragemTotal, $quantidadePostes, $numeroART, $engenheiro, $responsavelEmpresa, $responsavelComercial, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao atualizar serviço"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Dados incompletos"]);
}
?>