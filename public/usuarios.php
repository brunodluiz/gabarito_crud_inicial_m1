
<?php
session_start();
include("../infra/db/connect.php");
 
// Proteção: só acessa se estiver logado
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}
 
// Busca todos os usuários do banco
$sql = "SELECT * FROM usuarios";
$resultado = $conn->query($sql);
?>
 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-deletar {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-deletar:hover { background-color: #a71d2a; }
    </style>
</head>
<body>
 
<h1>Gerenciar Usuários</h1>
<p>Logado como: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong>
   | <a href="../index.php">Sair</a></p>
 
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $linha["id"] . "</td>";
                echo "<td>" . htmlspecialchars($linha["usuario"]) . "</td>";
                echo "<td>
                        <form method='POST' action='deletar_usuario.php'
                              onsubmit=\"return confirm('Tem certeza que deseja excluir o usuário " . htmlspecialchars($linha["usuario"]) . "?')\">
                            <input type='hidden' name='id' value='" . $linha["id"] . "'>
                            <button type='submit' class='btn-deletar'>Excluir</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum usuário cadastrado.</td></tr>";
        }
        ?>
    </tbody>
</table>
 
</body>
</html>