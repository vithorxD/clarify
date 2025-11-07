<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
            <?php 
            if (isset($_SESSION['user_id'])): 
            ?>
                <!-- criei o css dessas duas porras mas por algum motivo nao foi, tenta apagar e escrever literalmente
                do zero sem copiar nada deus da as batalhas mais dificeis aos seus guerreiros mais fortes -->
                <a href="../html/perfil.php" style="text-decoration: none;">
                    <button class="perfil">Meu Perfil</button>
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
    </nav>
    <nav class="navbar2">
        <div class="navbar-links2">
            <ul>
                <li class="right"><a href="../html/home.php">Inicio</a></li>
                <div class="barra"></div>
                <li><a href="../html/perguntas.php">Perguntas</a></li>
                <div class="barra"></div>
                <li><a href="/html/atividades.php">Atividades</a></li>
                <div class="barra"></div>
                <li><a href="../html/home.php#contato">Contato</a></li>
            </ul>
        </div>
        <div class="form">
            <input type="email" class="pesquisa" placeholder="🔍 PESQUISAR">
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>