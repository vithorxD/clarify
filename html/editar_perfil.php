<?php

include ('../php/conexao.php'); 
session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['user_id'];

// ve os dados dos usuarios nao importa de que tipo
$query = "
    SELECT 
        u.nome, 
        u.email,
        a.serie,
        p.especializacao
    FROM 
        usuario u
    LEFT JOIN 
        aluno a ON u.idUsuario = a.idUsuario
    LEFT JOIN 
        professor p ON u.idUsuario = p.idUsuario
    WHERE 
        u.idUsuario = '$idUsuario'
";

$resultado = mysqli_query($mysqli, $query) or die('Erro ao buscar dados para edição: ' . mysqli_error($mysqli));
$usuario = mysqli_fetch_assoc($resultado);

// determina o tipo de usuário para exibir campos específicos
$tipoUsuario = '';
if ($usuario['serie'] !== null) {
    $tipoUsuario = 'aluno';
} elseif ($usuario['especializacao'] !== null) {
    $tipoUsuario = 'professor';
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/editar_perfil.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">
    
    <?php include '../php/navbar.php'; ?>

    <h2>Editar Perfil de <?php echo htmlspecialchars($usuario['nome']); ?></h2>

    <form action="../php/salvar.php" method="POST">
        
        <h3>Dados Gerais</h3>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
        <br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
        <br>

        <?php if ($tipoUsuario == 'aluno'): ?>
            <h3>Dados do Aluno</h3>
            <label for="serie">Série:</label>
            <input type="text" id="serie" name="serie" value="<?php echo htmlspecialchars($usuario['serie']); ?>" required>
            <br>
        <?php elseif ($tipoUsuario == 'professor'): ?>
            <h3>Dados do Professor</h3>
            <label for="especializacao">Especialização:</label>
            <input type="text" id="especializacao" name="especializacao" value="<?php echo htmlspecialchars($usuario['especializacao']); ?>" required>
            <br>
            <label for="escolaAtual">Escola Atual:</label>
            <input type="text" id="escolaAtual" name="escolaAtual" value="<?php echo htmlspecialchars($usuario['escolaAtual']); ?>" required>
            <br>
        <?php endif; ?>

        <h3>Alterar Senha (Opcional)</h3>
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha">
        <br>
        <label for="confirma_senha">Confirme a Nova Senha:</label>
        <input type="password" id="confirma_senha" name="confirma_senha">
        <br>

        <button type="submit" name="submit">Salvar Alterações</button>
    </form>
    
    <a href="perfil.php">Cancelar e Voltar</a>

</body>
</html>