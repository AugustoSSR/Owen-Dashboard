<?php
include '../../includes/conexao.php';

error_log(print_r($_POST, true)); // Adiciona log para verificar os dados recebidos

if (isset($_POST['nome_projeto'], $_POST['cidade'], $_POST['empresa'], $_POST['concessionaria'], $_POST['metragem_total'], $_POST['quantidade_postes'], $_POST['numero_art'], $_POST['engenheiro'], $_POST['responsavel_empresa'], $_POST['responsavel_comercial'])) {
    $nomeProjeto = $_POST['nome_projeto'];
    $cidade = $_POST['cidade'];
    $empresa = $_POST['empresa'];
    $concessionaria = $_POST['concessionaria'];
    $metragemTotal = $_POST['metragem_total'];
    $quantidadePostes = $_POST['quantidade_postes'];
    $numeroART = $_POST['numero_art'];
    $engenheiro = $_POST['engenheiro'];
    $responsavelEmpresa = $_POST['responsavel_empresa'];
    $responsavelComercial = $_POST['responsavel_comercial'];

    // Verifica se todos os campos foram enviados corretamente
    if (empty($nomeProjeto) || empty($cidade) || empty($empresa) || empty($concessionaria) || empty($metragemTotal) || empty($quantidadePostes) || empty($numeroART) || empty($engenheiro) || empty($responsavelEmpresa) || empty($responsavelComercial)) {
        echo json_encode(["success" => false, "error" => "Dados incompletos"]);
        exit;
    }

    // Insere o serviço no banco de dados
    $sql = "INSERT INTO servicos (nome_projeto, cidade_id, empresa_id, concessionaria_id, metragem_total, quantidade_postes, numero_art, engenheiro_id, responsavel_empresa, responsavel_comercial) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "siiiiissss", 
                    $nomeProjeto, 
                    $cidade, 
                    $empresa, 
                    $concessionaria, 
                    $metragemTotal, 
                    $quantidadePostes, 
                    $numeroART, 
                    $engenheiro, 
                    $responsavelEmpresa, 
                    $responsavelComercial);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao inserir serviço"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Dados incompletos"]);
}
