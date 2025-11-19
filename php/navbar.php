<nav class="navbar">
        <img style="align-items: center;" src="../images/clarifyFinal.png" alt="logo">
        <div class="entrar">
            <?php 
            if (isset($_SESSION['user_id'])): 
            ?>
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
                    <button class="cadastro">Cadastro</button>
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
                <li><a href="../html/exercicio.php">Atividades</a></li>
            </ul>
        </div>
    </nav>
    <style>
        .navbar {
            display: flex;
            position: relative;
            align-items: center;
            background-color: #3C7096;
            border-bottom-color: #2F5775;
            border-bottom-style: solid;
            border-bottom-width: 5px;
            width: 100%;
        }

        .navbar img {
            width: 70px;
            align-items: flex-start;
        }

        .right {
            margin-left: auto;
        }

        .navbar-links {
            height: 100%;
        }

        .navbar-links ul {
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar-links li {
            list-style: none;
        }

        .navbar-links li a {
            display: block;
            text-decoration: none;
            padding: 1rem;
            color: #333;
            font-weight: 500;
        }

        .navbar-links li:hover {
            background-color: #99C0DA;
            border-radius: 25px;
        }
        
        .navbar2{
            display: flex;
            position: relative;
            align-items: center;
            background-color: #699EC3;
            border-bottom-color: #4989B6;
            border-bottom-style: solid;
            border-bottom-width: 5px;
        }
        .navbar-links2 {
            height: 100%;
        }

        .navbar-links2 ul {
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar-links2 li {
            list-style: none;
            
        }

        .navbar-links2 li a {
            display: block;
            text-decoration: none;
            padding: 1rem;
            color: white;
            font-weight: 500;

        }

        .navbar-links2 li:hover {
            background-color: #4989B6;
        }

        .barra{
            background-color: white;
            height: 30px;
            width: 2px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .entrar{
            display: flex;
            align-items: center;
            margin-left: auto;
            margin-right: 15px;
            gap: 10px;
        }

        .perfil, .logout, .login, .cadastro {
            display: flex;
            justify-content: center;
            min-width: 140px; /* Garante tamanho consistente */
            max-width: 170px;
            width: 100%;
            padding: 8px 50px; /* Padding ajustado */
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            outline: none;
            color: #fff;
            border: none;
            border-radius: 15px;
            /* Aqui definimos apenas os estilos comuns para todos os botões */
        }

        /* Estilos de cor e sombra específicos para a primeira coluna de botões (Perfil/Login) */
        .perfil, .login {
            background-color: #8AB3D0;
            box-shadow: 5px 5px #699EC3;
            margin-right: 10px; /* Mantém o espaçamento entre eles */
        }
        .perfil:hover, .login:hover {
            background-color: #699EC3;
            box-shadow: 5px 5px #4989B6;
        }

        .logout, .cadastro {
            background-color: #B6D0E2;
            box-shadow: 5px 5px #8AB3D0;
        }
        .logout:hover, .cadastro:hover {
            background-color: #8AB3D0;
            box-shadow: 5px 5px #699EC3;
        }
        @media (max-width: 360px) {
            nav{
                display: flex;
                flex-direction: column;
            }
        }
    </style>