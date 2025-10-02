<?php

include 'conexao.php';
session_start();

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, md5($POST['senha']));

    $select = mysqli_query($mysqli, "SELECT * FROM `cadastro` WHERE IdEmail = '$email' AND senha = '$senha'") or die('Erro na consulta');

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION[user_id] = row['id'];
        header('Location: ../html/login.php');
    }else{
        $message[] = 'Email ou senha incorreto(s). Tente novamente.'
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #4989B6;">
    <form method="POST" action="../php/teste.php" style="flex-wrap: wrap;">
        <div class="titulo">
            <h1>Faça seu login</h1>
        </div>
        <div class="campo-input">
            <label for="email">Seu e-mail:</label>
            <input type="email" name="email" id="email" />
        </div>
        <div class="campo-input">
            <label for="senha">Sua senha:</label>
            <input type="password" name="senha" id="senha" />
        </div>
        <input class="button" type="submit" name="submit" value="ENTRAR">
        <?php
                    if(isset($msg)){
                        foreach($msg as $msg){
                            echo '<div class="mensagem">' .$msg. </div>;
                        }
                    }
                ?>
        <p>
            Não tem uma conta? 
            <a href="../html/cadastro.php" style="text-decoration: none; color:#EDF3F8;">Faça seu cadastro</a>
        </p>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>