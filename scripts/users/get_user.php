<?php
// Inclua o arquivo de conexão com o banco de dados
include '../../includes/conexao.php';

// Verifique se o ID do usuário foi enviado por meio de uma requisição GET
if (isset($_GET['id'])) {
    // Prepare a consulta SQL para selecionar o usuário com base no ID fornecido
    $userId = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifique se o usuário foi encontrado
    if ($result->num_rows > 0) {
        // Retorne os dados do usuário como JSON
        $user = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'user' => $user]);
    } else {
        // Se o usuário não for encontrado, retorne uma mensagem de erro
        echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado']);
    }

    // Feche a conexão com o banco de dados e libere os recursos
    $stmt->close();
    $conn->close();
} else {
    // Se o ID do usuário não foi fornecido, retorne uma mensagem de erro
    echo json_encode(['status' => 'error', 'message' => 'ID do usuário não fornecido']);
}
