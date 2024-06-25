<?php
session_start();
include './includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
    exit();
}

$user_name = $_SESSION["name"];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cidades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/users.css">
    <link rel="stylesheet" href="css/alerts.css">

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Incluir DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
</head>

<body>
    <div id="alertContainer" class="alert-container"></div>
    <div class="dashboard-container">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3 class="dashboard-title">OWEN</h3>
            </div>
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Index</a></li>
                <li><a href="users.php"><i class="fas fa-users"></i> Usuários</a></li>
                <li><a href="cidades.php"><i class="fas fa-building"></i> Cidades</a></li>
                <li><a href="concessionarias.php"><i class="fas fa-lightbulb"></i> Concessionárias</a></li>
                <li><a href="services.php"><i class="fas fa-cogs"></i> Serviços</a></li>
                <li><a href="engenheiros.php"><i class="fas fa-tools"></i> Engenheiros</a></li>
                <li><a href="empresas.php"><i class="fas fa-industry"></i> Empresas</a></li>
            </ul>
            <hr>
            <div class="sidebar-footer">
                <div class="profile">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo $user_name; ?></span>
                </div>
                <button class="logout-btn" onclick="logout()"><i class="fas fa-sign-out-alt"></i></button>
            </div>
        </nav>
        <main class="main-content">
            <h1>Cadastro de Cidades</h1>
            <button class="add-btn" id="addCityBtn">Adicionar Cidade</button>
            <br>
            <table id="cityTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="cityList">
                    <!-- O corpo da tabela será preenchido pelo DataTables via AJAX -->
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal para adicionar cidade -->
    <div id="addCityModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Adicionar Cidade</h2>
            <form id="addCityForm">
                <label for="cityName">Nome:</label>
                <input type="text" id="cityName" name="nome" required>
                <button type="submit">Adicionar</button>
            </form>
        </div>
    </div>

    <!-- Modal para editar cidade -->
    <div id="editCityModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Cidade</h2>
            <form id="editCityForm">
                <input type="hidden" id="editCityId">
                <label for="editCityName">Nome:</label>
                <input type="text" id="editCityName" name="nome" required>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script src="js/cidades.js"></script>
</body>

</html>