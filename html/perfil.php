<?php

include ('../php/conexao.php');
session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['user_id'];

// busca os dados do usuário, seja ele aluno ou professor
$query = "
    SELECT 
        u.nome, 
        u.email,
        u.idUsuario,
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

$resultado = mysqli_query($mysqli, $query) or die('Erro ao buscar dados do usuário: ' . mysqli_error($mysqli));

if(mysqli_num_rows($resultado) > 0){
    $usuario = mysqli_fetch_assoc($resultado);
    
    // determina o tipo do usuario
    $tipoUsuario = '';
    if ($usuario['serie'] !== null) {
        $tipoUsuario = 'aluno';
    } elseif ($usuario['especializacao'] !== null) {
        $tipoUsuario = 'professor';
    }
    
    $_SESSION['user_type'] = $tipoUsuario; 
    
} else {
    $mensagemErro = "Dados do perfil não encontrados.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link rel="stylesheet" href="../css/perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">
    <?php include '../php/navbar.php'; ?>

    <form action="">
    <div class="perfil-container">
        
        <h2 class="titulo">Olá, <?php echo htmlspecialchars($usuario['nome']); ?>!</h2>
        
        <p class="subtitulo"><strong>Tipo de Conta:</strong> 
            <?php 
                if ($tipoUsuario == 'aluno') {
                    echo 'Aluno';
                } elseif ($tipoUsuario == 'professor') {
                    echo 'Professor';
                } else {
                    echo 'Usuário Não Classificado';
                }
            ?>
        </p>
        <hr>

        <div class="divisao">
        <div class="informacoes-gerais">
            <h3 class="dados">Dados Pessoais</h3>
            <p class="nome"><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
            <p class="email"><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        </div>

        <?php if ($tipoUsuario == 'aluno'): ?>
            <div class="informacoes-aluno">
                <h3 class="aluno">Dados do Aluno</h3>
                <p class="serie"><strong>Série:</strong> <?php echo htmlspecialchars($usuario['serie']); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($tipoUsuario == 'professor'): ?>
            <div class="informacoes-professor">
                <h3 class="professor">Dados do Professor</h3>
                <p class="especializacao"><strong>Especialização:</strong> <?php echo htmlspecialchars($usuario['especializacao']); ?></p>
            </div>
        <?php endif; ?>
        </div>

        <div class="botao">
            <div class="editar" style="margin-right: 5px;">
                <a href="../html/editar_perfil.php" class="btn" style="text-decoration: none; color: white;" type="button">Editar Perfil</a>
            </div>
            <div class="sair" style="margin-left: 5px;">
                <a href="../php/deletar.php" class="btn" style="text-decoration: none; color: white;">Deletar Conta</a>
            </div>
        </div>
    </div>  
    </form>
</body>
</html>