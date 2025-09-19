<?php
    session_start( );
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: ../html/login.php');
    }
    $logado = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/telaprincipal.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">
    <nav class="navbar">
        <img src="/images/clarifyv1.png" alt="logo">
        <div class="navbar-links">
        </div>
        <a href="../html/login.php" style="text-decoration: none;"><button class="login" >Login</button></a>
        <a href="../html/cadastro.php" style="text-decoration: none;"><button class="cadastro" >Cadastro</button></a>
    </nav>
    <nav class="navbar2">
        <div class="navbar-links2">
            <ul>
                <li class="right"><a href="../html/telaprincipal.php">Inicio</a></li>
                <div class="barra"></div>
                <li><a href="/html/perguntas.html">Perguntas</a></li>
                <div class="barra"></div>
                <li><a href="/html/perguntas.html">Atividades</a></li>
                <div class="barra"></div>
                <li><a href="/html/contato.html">Contato</a></li>
                <div class="barra"></div>
                <li><a href="/html/perfil.html">Perfil</a></li>
            </ul>
        </div>
        <div class="form">
            <input type="email" class="pesquisa" placeholder="🔍 PESQUISAR">
        </div>
    </nav>
    <div class="introducao">
        <h1>Sane suas dúvidas!</h1>
        <p>Um site onde professores e alunos se ajudam para clarear seus estudos.</br>Mande sua pergunta como aluno, ou ajude como professor! De graça!</p>
        <h5>“A sabedoria é a própria recompensa.”</h5>
        <button class="criar"><a href="#">Faça a sua pergunta aqui!</a></button>
    </div>
    <div class="linha"></div>
    <div class="card">
        <div class="card-body" style="background-color: #B6D0E2; text-decoration: none;">
            <h3 class="card-title">Usuario inteligente</h3>
            <p class="card-text">Assinale a alternativa que apresenta a resposta correta.</br>Questão 13</br>Escolha uma opção:</br>a.1</br>b.9</br>c.0</br>d.2</br>e.+∞</p>
            <a href="#" style="text-decoration: none; color:#213F54;"></a><button class="responder">Responder</button></a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>