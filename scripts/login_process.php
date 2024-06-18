<?php
session_start();
include '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = protect_input($_POST["email"]);
    $password = protect_input($_POST["password"]);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            if ($row["is_active"] == 1) {
                // Usuário ativo
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["name"] = $row["name"];
                header("Location: ../dashboard.php");
            } else {
                // Usuário inativo
                $_SESSION["email"] = $row["email"];
                $_SESSION["is_active"] = true;
                header("Location: ../await_activation.php");
            }
        } else {
            header("Location: ../index.php?error=wrong_password");
        }
    } else {
        header("Location: ../index.php?error=user_not_found");
    }
}

$conn->close();
exit();
