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
            <?php 
            if (isset($_SESSION['user_id'])): 
            ?>
                <!-- criei o css dessas duas porras mas por algum motivo nao foi, tenta apagar e escrever literalmente
                do zero sem copiar nada deus da as batalhas mais dificeis aos seus guerreiros mais fortes -->
                <a href="../html/perfil.php" style="text-decoration: none;">
                    <button class="perfil">Meu Per  fil</button>
                </a>
                <a href="../php/logout.php" style="text-decoration: none;">
                    <button class="logout">Sair</button>
                </a>
            <?php 
            else: 
            ?>
                <a href="../html/login.php" style="text-decoration: none;">
                    <button class="login" >Login</button>
                </a>
                <a href="../html/cadastro.php" style="text-decoration: none;">
                    <button class="cadastro" >Cadastro</button>
                </a>
            <?php endif; ?>
        </div>
    </nav><nav class="navbar">
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
                <li class="right"><a href="../html/home.php">Inicio</a></li>
                <div class="barra"></div>
                <li><a href="../html/perguntas.php">Perguntas</a></li>
                <div class="barra"></div>
                <li><a href="../html/exercicio.php">Atividades</a></li>
                <div class="barra"></div>
                <li><a href="#scroll2">Contato</a></li>
            </ul>
        </div>
        <div class="form">
            <input type="email" class="pesquisa" placeholder="🔍 PESQUISAR">
        </div>
    </nav>

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
        </div>
        <?php endif; ?>

        <?php if ($tipoUsuario == 'professor'): ?>
            <div class="informacoes-professor">
                <h3>Dados do Professor</h3>
                <p><strong>Especialização:</strong> <?php echo htmlspecialchars($usuario['especializacao']); ?></p>
                </div>
        <?php endif; ?>

        <div class="botao">
            <div class="editar">
                <a href="../html/editar_perfil.php" class="btn">Editar Perfil</a>
            </div>
            <div class="sair">
                <a href="../php/logout.php" class="btn">Sair</a>
            </div>
        </div>
    </div>
    </form>
</body>
</html>