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
                <li><a href="../html/exercicio.php">Atividades</a></li>
                <div class="barra"></div>
                <li><a href="#scroll2">Contato</a></li>
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

        .pesquisa{
            width: 250px;
            padding: 12px 20px;
            display: flex;
            align-items: right;
            justify-content: right;
            margin-right: 15px;
            border-radius: 25px;
            box-sizing: border-box;
            background-color: #CCDEEB;
            color: #373737;
            border: none;
        }

        .pesquisa, input:hover, input:active, input:focus {
        outline: 0;
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
            align-items: right;
            margin-right: 15px;
        }

        .login{
            display: flex;
            justify-content: center;
            padding: 8px 50px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #8AB3D0;
            border: none;
            border-radius: 15px;
            box-shadow: 5px 5px #699EC3;
            gap: 10px;
            margin-right: 10px;
        }

        .login:hover {
            background-color: #699EC3;
            box-shadow: 5px 5px #4989B6;
        }

        .login:active {
        background-color: #699EC3;
        box-shadow: 5px 5px #4989B6;
        transform: translateY(2px);
        }

        .cadastro{
            display: flex;
            justify-content: center;
            padding: 8px 50px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #B6D0E2;
            border: none;
            border-radius: 15px;
            box-shadow: 5px 5px #8AB3D0;
        }

        .cadastro:hover {
            background-color: #8AB3D0;
            box-shadow: 5px 5px #699EC3;
        }

        .cadastro:active {
            background-color: #8AB3D0;
            box-shadow: 5px 5px #699EC3;
            transform: translateY(2px);
        }
        .perfil{
            display: flex;
            justify-content: center;
            padding: 8px 50px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #8AB3D0;
            border: none;
            border-radius: 15px;
            box-shadow: 5px 5px #699EC3;
            gap: 10px;
            margin-right: 10px;
        }

        .perfil:hover {
            background-color: #699EC3;
            box-shadow: 5px 5px #4989B6;
        }

        .perfil:active {
            background-color: #699EC3;
            box-shadow: 5px 5px #4989B6;
            transform: translateY(2px);
        }

        .logout{
            display: flex;
            justify-content: center;
            padding: 8px 50px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #B6D0E2;
            border: none;
            border-radius: 15px;
            box-shadow: 5px 5px #8AB3D0;
        }

        .logout:hover {
            background-color: #8AB3D0;
            box-shadow: 5px 5px #699EC3;
        }

        .logout:active {
            background-color: #8AB3D0;
            box-shadow: 5px 5px #699EC3;
            transform: translateY(2px);
        }
    </style>