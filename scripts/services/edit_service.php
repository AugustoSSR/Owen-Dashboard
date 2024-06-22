<?php
include '../../includes/conexao.php';

if (isset($_POST['servico_id'], $_POST['nome_projeto'], $_POST['cidade'], $_POST['empresa'], $_POST['concessionaria'], $_POST['metragem_total'], $_POST['quantidade_postes'], $_POST['numero_art'], $_POST['engenheiro'], $_POST['responsavel_empresa'], $_POST['responsavel_comercial'])) {
    $servicoId = $_POST['servico_id'];
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

    // Atualiza o serviço no banco de dados
    $sql = "UPDATE servicos SET nome_projeto = ?, cidade_id = ?, empresa_id = ?, concessionaria_id = ?, metragem_total = ?, quantidade_postes = ?, numero_art = ?, engenheiro_id = ?, responsavel_empresa = ?, responsavel_comercial = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiiisiisi", $nomeProjeto, $cidade, $empresa, $concessionaria, $metragemTotal, $quantidadePostes, $numeroART, $engenheiro, $responsavelEmpresa, $responsavelComercial, $servicoId);

    if ($stmt->execute()) {
        // Remove postes existentes
        $sqlDelete = "DELETE FROM poste WHERE servico_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $servicoId);
        $stmtDelete->execute();

        // Adiciona novos postes
        if (isset($_POST['nome_rua'], $_POST['numero_postes'])) {
            $nomeRuas = $_POST['nome_rua'];
            $numeroPostes = $_POST['numero_postes'];

            $sqlInsert = "INSERT INTO poste (servico_id, nome_rua, numero_postes) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);

            for ($i = 0; $i < count($nomeRuas); $i++) {
                $stmtInsert->bind_param("isi", $servicoId, $nomeRuas[$i], $numeroPostes[$i]);
                $stmtInsert->execute();
            }
        }

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao atualizar serviço"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Dados incompletos"]);
}
