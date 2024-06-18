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
    <title>Lista de Usuários</title>
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
            <h1>Lista de Usuários</h1>
            <button class="add-btn" id="addUserBtn">Adicionar Usuário</button>
            <br>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="userList">
                    <?php
                    include './includes/conexao.php';

                    // Consulta os usuários na tabela
                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Exibe os usuários na tabela
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . ($row["is_active"] == 1 ? "Ativo" : "Inativo") . "</td>";
                            echo "<td>";
                            echo "<button class='btn edit-btn' onclick='editUser(" . $row["id"] . ")'>Editar</button>";
                            echo "<button class='btn delete-btn' onclick='deleteUser(" . $row["id"] . ")'>Excluir</button>";
                            echo "<button class='btn view-btn' onclick='viewUser(" . $row["id"] . ")'>Visualizar</button>";
                            echo "<button class='btn toggle-btn' onclick='toggleActivation(" . $row["id"] . ")'>" . ($row["is_active"] == 1 ? "Desativar" : "Ativar") . "</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum usuário encontrado</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>



        </main>
    </div>

    <!-- Modal para visualizar o usuário -->
    <div id="viewUserModal" class="modal">
        <div class="modal-content">
            <span id="viewUserModalClose" class="close">&times;</span>
            <h2>Visualizar Usuário</h2>
            <p><strong>Nome:</strong> <span id="viewName"></span></p>
            <p><strong>Email:</strong> <span id="viewEmail"></span></p>
            <p><strong>Status:</strong> <span id="viewStatus"></span></p>
        </div>
    </div>

    <!-- Modal para editar o usuário -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Usuário</h2>
            <form id="editUserForm">
                <input type="hidden" id="editUserId">
                <label for="editName">Nome:</label>
                <input type="text" id="editUserName" name="name" required>
                <label for="editEmail">Email:</label>
                <input type="email" id="editUserEmail" name="email" required>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>


    <!-- Modal para adicionar usuário -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Adicionar Usuário</h2>
            <form action="../scripts/add_user.php" method="POST" id="addUserForm">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit" class="add-btn">Adicionar</button>
            </form>
        </div>
    </div>
    <script src="js/users.js"></script>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>


</body>

</html>