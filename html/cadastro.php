<?php

include ('/xampp/htdocs/clarify/php/conexao.php');

if(isset($_POST['submit'])){

    $message = [];

    $nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));
    //csenha é só pra comparacao rpzd nao precisa estar no banco viu :p
    $csenha = mysqli_real_escape_string($mysqli, md5($_POST['csenha']));
    $serie = mysqli_real_escape_string($mysqli, ($_POST['serie']));

    // ve se as senha tao iguais isso é obvio gente vamos nos antenar
    if ($senha != $csenha) {
        $message[] = 'Senhas não coincidem.';
    } else {
        // ve se o email ja existe pq só pode existir um email por cadastro DURRRR
        $select = mysqli_query($mysqli, "SELECT * FROM `usuario` WHERE email = '$email'") or die('Erro na consulta de email');

        if(mysqli_num_rows($select) > 0){
            $message[] = 'Já existe um usuário cadastrado com este e-mail.';
        } else {
            // coloca os dados na tabela usuario
            $insert_usuario = mysqli_query($mysqli, "INSERT INTO usuario(nome, email, senha) VALUES ('$nome', '$email', '$senha')") or die('Erro na inserção do usuário');
            
            if($insert_usuario){
                // pega o id recem cadastrado, ja usa o auto increment ja sLK QUE TECNOLOGIA
                $idUsuario = mysqli_insert_id($mysqli); 

                // coloca no cadastroaluno
                $insert_aluno = mysqli_query($mysqli, "INSERT INTO aluno(idUsuario, serie) VALUES ('$idUsuario', '$serie')") or die('Erro na inserção do aluno');

                if ($insert_aluno) {
                    $message[] = 'Cadastro de aluno concluído com sucesso!';
                    header('Location: ../html/login.php');
                    exit();
                } else {
                    $message[] = 'Cadastro de aluno falhou. Tente novamente.';
                }
            } else {
                $message[] = 'Cadastro de usuário falhou.';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Clarify</title>
    <link rel="icon" type="imagex/png" href="../images/clarifyFinal.png">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #4989B6;" style="flex-wrap: wrap;">
    <form method="POST" action="cadastro.php" class="container" style="max-width: 500px; width: 100%;">
        <div class="row mb-4 justify-content-center">
            <div class="col-12 text-center titulo">
                <h1>Faça seu cadastro</h1>
            </div>
        </div>                
        <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="mensagem">'.$message.'</div>';
                }
            } 
        ?>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" placeholder="Insira seu nome" name="nome" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="email">Seu email:</label>
                <input type="email" id="email" placeholder="Insira seu email" name="email" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="senha">Crie uma senha:</label>
                <input type="password" id="senha" placeholder="Insira sua senha" name="senha" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="csenha">Confirme sua senha:</label>
                <input type="password" id="csenha" placeholder="Confirme sua senha" name="csenha" required>
            </div>
        </div>
        <div class="campo-input">
            <label for="serie">Especialização:</label>
            <select name="serie" id="serie">
                <option value="6° Ano">6° Ano</option>
                <option value="7° Ano">7° Ano</option>
                <option value="8° Ano">8° Ano</option>
                <option value="9° Ano">9° Ano</option>
                <option value="1° Ano do Ensino Medio">1° Ano do Ensino Médio</option>
                <option value="2° Ano do Ensino Medio">2° Ano do Ensino Médio</option>
                <option value="3° Ano do Ensino Médio">3° Ano do Ensino Médio</option>
            </select>
        </div>
        <div class="row mb-3 justify-content-center">
            <div class="col-12 text-center">
                <input type="submit" name="submit" value="CADASTRAR" class="button">
            </div>
        </div>
        <div class="row mb-2 justify-content-center">
            <div class="col-12 text-center">
                <p>
                    É professor(a)?
                    <a href="../html/cadastroprof.php" style="text-decoration: none; color:#EDF3F8;">Clique aqui!</a>
                </p>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>