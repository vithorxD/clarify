<?php
    session_start( );
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
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
    <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
        <div class="introducao">
            <h1 class="scroll1">Sane suas dúvidas!</h1>
            <p>Um site onde professores e alunos se ajudam para clarear seus estudos.</br>Mande sua pergunta como aluno, ou ajude como professor! De graça!</p>
            <h5>"A sabedoria é a própria recomepensa."</h5>
            <button class="criar"><a href="../html/criar.php">Faça a sua pergunta aqui!</a></button>
            <button class="visita"><a href="#">Visite exercícios enviados por professores!</a></button>
        </div>
        <div class="contato">
            <h1 class="scroll2">Quem somos nós?</h1>
            <p class="p1">Nós da Clarify buscamos auxiliar vocês alunos com suas dúvidas e seus estudos!</br>Nosso sistema oferece maior acessibilidade a professores qualificados e diversos exercícios para você praticar.</br>Esperamos ajudar você da melhor maneira possível!</p>
            <p class="p2">Caso precise relatar algum problema, entre contato com a nossa empresa:</p>
            <h3>clarify@gmail.com</h3>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>