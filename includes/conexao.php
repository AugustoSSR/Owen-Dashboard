<?php
// Arquivo de conexão com o banco de dados MySQL

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_dash";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para proteger contra SQL Injection
if (!function_exists('protect_input')) {
    function protect_input($data)
    {
        global $conn;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = $conn->real_escape_string($data);
        return $data;
    }
}
