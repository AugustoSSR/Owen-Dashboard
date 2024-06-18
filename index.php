<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Registro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form id="registerForm" action="scripts/register_process.php" method="POST">
                <h1>Criar Conta</h1>
                <input type="text" placeholder="Nome" id="registerName" name="name" required>
                <input type="email" placeholder="Email" id="registerEmail" name="email" required>
                <input type="password" placeholder="Senha" id="registerPassword" name="password" required>
                <button type="submit">Registrar</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form id="loginForm" action="scripts/login_process.php" method="POST">
                <h1>Entrar</h1>
                <input type="email" placeholder="Email" id="loginEmail" name="email" required>
                <input type="password" placeholder="Senha" id="loginPassword" name="password" required>
                <button type="submit">Login</button>
                <?php if (isset($_GET['error'])) : ?>
                    <p class="error">
                        <?php
                        if ($_GET['error'] == 'wrong_password') {
                            echo "Senha incorreta. Por favor, tente novamente.";
                        } elseif ($_GET['error'] == 'user_not_found') {
                            echo "Usuário não encontrado. Por favor, registre-se.";
                        }
                        ?>
                    </p>
                <?php endif; ?>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bem Vindo de Volta!</h1>
                    <p>Para se manter conectado, faça login com suas informações pessoais</p>
                    <button class="ghost" id="signIn">Login</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Olá, Amigo!</h1>
                    <p>Entre com seus dados pessoais e comece a jornada conosco</p>
                    <button class="ghost" id="signUp">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>