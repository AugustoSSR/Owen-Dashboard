<?php
session_start();
include 'includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$user_name = $_SESSION["name"];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
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
            <h1>Dashboard</h1>
            <div class="cards">
                <div class="card">
                    <h2>Total de Usuários</h2>
                    <p id="totalUsers">0</p>
                </div>
                <div class="card">
                    <h2>Usuários a Serem Ativados</h2>
                    <p id="pendingUsers">0</p>
                </div>
                <div class="card">
                    <h2>Usuários Ativos</h2>
                    <p id="activeUsers">0</p>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/dashboard.js"></script>
</body>

</html>