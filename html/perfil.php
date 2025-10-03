<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/perfil.css">
    <title>Clarify</title>
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
     <form method="POST" action="../php/teste.php" style="flex-wrap: wrap;">
        <div class="perfil">
            <h1>Perfil do Usuário</h1>
        </div>
        <div class="campo-input">
            <input type="user" class="nome" placeholder="Nome do usuário" aria-label="Disabled input example" disabled>
        </div>
        <div class="campo-input">
            <input type="user" class="username" placeholder="Username" aria-label="Disabled input example" disabled>
        </div>
        <div class="campo-input">
             <input type="email" class="email" placeholder="email@exemplo.com" aria-label="Disabled input example" disabled>
        </div>
        <div class="campo-input">
            <input type="password" class="form-control" placeholder="Senha" aria-label="Disabled input example" disabled>
        </div>
        <div class="editar">
            <a href="#"><button>Editar</button></a>
        </div>
    </form>
    <div class="sair" style="align-items: center;">
        <a href="../html/login.php" style="text-decoration: none;"><button class="logout">Log out</button></a>
        <button class="deletar">Deletar conta</button>
    </div>
</body>
</html>