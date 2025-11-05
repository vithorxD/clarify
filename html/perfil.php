<?php
// perfil.php

include ('../php/conexao.php'); // Sua conexão com o BD
session_start();

// 1. Verificação de segurança: Redireciona se o usuário não estiver logado
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['user_id'];

// 2. Consulta SQL unificada (LEFT JOIN)
// Esta consulta traz os dados gerais do usuário E as especificações de aluno/professor, se existirem.
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
    
    // 3. Determinar o tipo de usuário para facilitar a visualização
    $tipoUsuario = '';
    if ($usuario['serie'] !== null) {
        $tipoUsuario = 'aluno';
    } elseif ($usuario['especializacao'] !== null) {
        $tipoUsuario = 'professor';
    }
    
    // Você pode armazenar o tipo na sessão aqui, caso o login não tenha feito.
    $_SESSION['user_type'] = $tipoUsuario; 
    
} else {
    // Caso o usuário esteja logado, mas o registro não exista (erro grave)
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
    <nav class="navbar">
        <img src="../images/clarifyv1.png" alt="logo">
        <div class="navbar-links">
        </div>
        <div class="entrar">
            <a href="../html/login.php" style="text-decoration: none;"><button class="login" >Login</button></a>
            <a href="../html/cadastro.php" style="text-decoration: none;"><button class="cadastro" >Cadastro</button></a>
        </div>
    </nav>
    <nav class="navbar2">
        <div class="navbar-links2">
            <ul>
                <li class="right"><a href="#scroll1">Inicio</a></li>
                <div class="barra"></div>
                <li><a href="/html/criar.php">Perguntas</a></li>
                <div class="barra"></div>
                <li><a href="/html/perguntas.html">Atividades</a></li>
                <div class="barra"></div>
                <li><a href="#scroll2">Contato</a></li>
                <div class="barra"></div>
                <li><a href="../html/perfil.php">Perfil</a></li>
            </ul>
        </div>
        <div class="form">
            <input type="email" class="pesquisa" placeholder="🔍 PESQUISAR">
        </div>
    </nav>

    <form action="">
    <div class="perfil-container">
        
        <h2>Olá, <?php echo htmlspecialchars($usuario['nome']); ?>!</h2>
        
        <p><strong>Tipo de Conta:</strong> 
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

        <div class="informacoes-gerais">
            <h3>Dados Pessoais</h3>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        </div>

        <?php if ($tipoUsuario == 'aluno'): ?>
            <div class="informacoes-aluno">
                <h3>Dados do Aluno</h3>
                <p><strong>Série:</strong> <?php echo htmlspecialchars($usuario['serie']); ?></p>
                </div>
        <?php endif; ?>

        <?php if ($tipoUsuario == 'professor'): ?>
            <div class="informacoes-professor">
                <h3>Dados do Professor</h3>
                <p><strong>Especialização:</strong> <?php echo htmlspecialchars($usuario['especializacao']); ?></p>
                <p><strong>Escola Atual:</strong> <?php echo htmlspecialchars($usuario['escolaAtual']); ?></p>
                </div>
        <?php endif; ?>

        <a href="editar_perfil.php" class="btn-editar">Editar Perfil</a> <br>
        <a href="../php/logout.php">Sair</a>
    </div>
    </form>
</body>
</html>