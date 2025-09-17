<?php

if(isset($_POST['submit'])){

    include('/xampp/htdocs/clarify/php/conexao.php');

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['senha'];

    $result = mysqli_query($mysqli, "INSERT INTO teste(id,email,senha,nome) VALUES('$id','$email','$senha','$nome')");

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #4989B6;">
    <form method="POST" action="/php/cadastro.php" class="container" style="max-width: 500px; width: 100%;">
        <div class="row mb-4 justify-content-center">
            <div class="col-12 text-center titulo">
                <h1>Faça seu cadastro</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="email">Seu email:</label>
                <input type="email" id="email" name="email" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="senha">Crie uma senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 campo-input">
                <label for="confirmar_senha">Confirme sua senha:</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required>
            </div>
        </div>
        <div class="row mb-3 justify-content-center">
            <div class="col-12 text-center">
                <button type="submit" name="submit" id="submit">CONFIRMAR</button>
            </div>
        </div>
        <div class="row mb-2 justify-content-center">
            <div class="col-12 text-center">
                <p>
                    É professor(a)?
                    <a href="/html/cadastroprof.html" style="text-decoration: none; color:#EDF3F8;">Clique aqui!</a>
                </p>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>