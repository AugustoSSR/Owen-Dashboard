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
    <title>Lista de Serviços</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/services.css">
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
            <h1>Lista de Serviços</h1>
            <button class="add-btn" id="addServiceBtn">Adicionar Serviço</button>
            <br>
            <table id="serviceTable">
                <thead>
                    <tr>
                        <th>Nome Projeto</th>
                        <th>Cidade</th>
                        <th>Empresa</th>
                        <th>Concessionaria</th>
                        <th>Metragem Total</th>
                        <th>Quantidade de Postes</th>
                        <th>Número ART</th>
                        <th>Engenheiro</th>
                        <th>Responsável Empresa</th>
                        <th>Responsável Comercial</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="serviceList">
                    <!-- Dados dos serviços virão do backend via AJAX -->
                </tbody>
            </table>
        </main>
    </div>

    <!-- Add Service Modal -->
    <div id="addServiceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Adicionar Serviço</h2>
            <form id="addServiceForm">
                <label for="nome_projeto">Nome do Projeto:</label>
                <input type="text" id="nome_projeto" name="nome_projeto" required>

                <label for="cidade">Cidade:</label>
                <select id="cidadeSelect" name="cidade" required></select>

                <label for="empresa">Empresa:</label>
                <select id="empresaSelect" name="empresa" required></select>

                <label for="concessionaria">Concessionária:</label>
                <select id="concessionariaSelect" name="concessionaria" required></select>

                <label for="metragem_total">Metragem Total:</label>
                <input type="number" id="metragem_total" name="metragem_total" required>

                <label for="quantidade_postes">Quantidade de Postes:</label>
                <input type="number" id="quantidade_postes" name="quantidade_postes" required>

                <label for="numero_art">Número ART:</label>
                <input type="text" id="numero_art" name="numero_art" required>

                <label for="engenheiro">Engenheiro:</label>
                <select id="engenheiroSelect" name="engenheiro" required></select>

                <label for="responsavel_empresa">Responsável pela Empresa:</label>
                <input type="text" id="responsavel_empresa" name="responsavel_empresa" required>

                <label for="responsavel_comercial">Responsável Comercial:</label>
                <input type="text" id="responsavel_comercial" name="responsavel_comercial" required>

                <button type="submit">Adicionar</button>
            </form>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Serviço</h2>
            <form id="editServiceForm">
                <input type="hidden" id="editServiceId" name="id">
                <label for="editNomeProjeto">Nome do Projeto:</label>
                <input type="text" id="editNomeProjeto" name="nome_projeto" required>

                <label for="editCidade">Cidade:</label>
                <select id="editCidade" name="cidade" required></select>

                <label for="editEmpresa">Empresa:</label>
                <select id="editEmpresa" name="empresa" required></select>

                <label for="editConcessionaria">Concessionária:</label>
                <select id="editConcessionaria" name="concessionaria" required></select>

                <label for="editMetragemTotal">Metragem Total:</label>
                <input type="number" id="editMetragemTotal" name="metragem_total" required>

                <label for="editQuantidadePostes">Quantidade de Postes:</label>
                <input type="number" id="editQuantidadePostes" name="quantidade_postes" required>

                <label for="editNumeroART">Número ART:</label>
                <input type="text" id="editNumeroART" name="numero_art" required>

                <label for="editEngenheiro">Engenheiro:</label>
                <select id="editEngenheiro" name="engenheiro" required></select>

                <label for="editResponsavelEmpresa">Responsável pela Empresa:</label>
                <input type="text" id="editResponsavelEmpresa" name="responsavel_empresa" required>

                <label for="editResponsavelComercial">Responsável Comercial:</label>
                <input type="text" id="editResponsavelComercial" name="responsavel_comercial" required>

                <label for="editPosteList">Postes:</label>
                <ul id="editPosteList"></ul>

                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <!-- View Service Modal -->
    <div id="viewServiceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Visualizar Serviço</h2>
            <p><strong>Nome do Projeto:</strong> <span id="viewNomeProjeto"></span></p>
            <p><strong>Cidade:</strong> <span id="viewCidade"></span></p>
            <p><strong>Empresa:</strong> <span id="viewEmpresa"></span></p>
            <p><strong>Concessionária:</strong> <span id="viewConcessionaria"></span></p>
            <p><strong>Metragem Total:</strong> <span id="viewMetragemTotal"></span></p>
            <p><strong>Quantidade de Postes:</strong> <span id="viewQuantidadePostes"></span></p>
            <p><strong>Número ART:</strong> <span id="viewNumeroART"></span></p>
            <p><strong>Engenheiro:</strong> <span id="viewEngenheiro"></span></p>
            <p><strong>Responsável pela Empresa:</strong> <span id="viewResponsavelEmpresa"></span></p>
            <p><strong>Responsável Comercial:</strong> <span id="viewResponsavelComercial"></span></p>
            <p><strong>Postes:</strong></p>
            <ul id="viewPosteList"></ul>
        </div>
    </div>

    <script src="js/services.js"></script>
</body>

</html>