<?php
session_start();
include '../includes/conexao.php';

// Verifica se o email está presente na sessão
if (!isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = protect_input($_POST["password"]);
    $confirm_password = protect_input($_POST["confirm_password"]);

    if ($password === $confirm_password) {
        // A senha é válida, então podemos atualizá-la no banco de dados
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            // Senha atualizada com sucesso, redireciona para a página de login ou outra página conforme necessário
            header("Location: ../index.php?registration_pending=true");
            exit();
        } else {
            echo "Erro ao atualizar a senha: " . $stmt->error;
        }
    } else {
        echo "As senhas não coincidem. Por favor, tente novamente.";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Definir Senha</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/modal.css">
    <script src="../js/modal.js"></script>
</head>

<body>
    <div class="dashboard-container">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Meu Dashboard</h3>
            </div>
        </nav>
        <main class="main-content">
            <h1>Definir Senha</h1>
            <p>Olá, <?php echo htmlspecialchars($email); ?>. Por favor, defina sua senha.</p>
            <form id="setPasswordForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password">Confirmar Senha:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <button type="submit">Salvar Senha</button>
            </form>
            <button onclick="window.location.href='../scripts/logout.php'" class="logout-btn">Sair</button>
        </main>
    </div>

    <div id="setPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Definir Senha</h2>
            <form id="setPasswordForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password">Confirmar Senha:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <button type="submit">Salvar Senha</button>
            </form>
            <button onclick="window.location.href='../scripts/logout.php'" class="logout-btn">Sair</button>
        </div>
    </div>

    <script src="../js/modal.js"></script>
</body>

</html>