<?php
session_start();
include("../infra/db/connect.php");
 
// Proteção: só acessa se estiver logado
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}
 
// Verifica se chegou um ID via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]); // intval() converte para inteiro, evitando SQL Injection
 
    $sql = "DELETE FROM usuarios WHERE id = $id";
 
    if ($conn->query($sql)) {
        // Exclusão bem-sucedida: redireciona de volta à lista
        header("Location: usuarios.php?mensagem=Usuario+excluido+com+sucesso");
        exit();
    } else {
        // Erro ao executar a query
        echo "Erro ao excluir usuário: " . $conn->error;
    }
} else {
    // Acesso indevido sem POST
    header("Location: usuarios.php");
    exit();
}
?>
 