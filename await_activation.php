<?php
session_start();
if (!isset($_SESSION["inactive"]) || !$_SESSION["inactive"]) {
    header("Location: ./index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aguardando Ativação</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/await_activation.css">
</head>

<body>
    <div class="dashboard-container">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Meu Dashboard</h3>
            </div>
        </nav>
        <main class="main-content">
            <h1>Conta Aguardando Ativação</h1>
            <p>Olá, <?php echo htmlspecialchars($_SESSION["email"]); ?>. Sua conta ainda não foi ativada. Por favor, aguarde até que um administrador ative sua conta.</p>
            <button onclick="window.location.href='./scripts/logout.php'" class="logout-btn">Sair</button>
        </main>
    </div>
</body>

</html>