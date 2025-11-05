<?php

//é a msm fita que o cadastro do aluno, qualquer duvida ve la q eu explico bonitinho
include ('/xampp/htdocs/clarify/php/conexao.php');

if(isset($_POST['submit'])){

    $nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));
    $csenha = mysqli_real_escape_string($mysqli, md5($_POST['csenha']));
    $especializacao = mysqli_real_escape_string($mysqli, ($_POST['especializacao'])); 
    $escolaAtual = mysqli_real_escape_string($mysqli, ($_POST['escolaAtual'])); 

    if ($senha != $csenha) {
        $message[] = 'Senhas não coincidem.';
    } else {
        $select = mysqli_query($mysqli, "SELECT * FROM `usuario` WHERE email = '$email'") or die('Erro na consulta de email');

        if(mysqli_num_rows($select) > 0){
            $message[] = 'Já existe um usuário cadastrado com este e-mail.';
        } else {
            $insert_usuario = mysqli_query($mysqli, "INSERT INTO usuario(nome, email, senha) VALUES ('$nome', '$email', '$senha')") or die('Erro na inserção do usuário');
            
            if($insert_usuario){
                $idUsuario = mysqli_insert_id($mysqli); 

                $insert_professor = mysqli_query($mysqli, "INSERT INTO professor(idUsuario, especializacao, escolaAtual) VALUES ('$idUsuario', '$especializacao', '$escolaAtual')") or die('Erro na inserção do professor');

                if ($insert_professor) {
                    $message[] = 'Cadastro de professor concluído com sucesso!';
                    header('Location: ../html/confirmacao.php');
                    exit(); 
                } else {
                    $message[] = 'Cadastro de professor falhou. Tente novamente.';
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
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #4989B6;">
    <form action="" style="flex-wrap: wrap;">
        <div class="titulo">
            <h1>Faça seu cadastro</h1>
        </div>
        <div class="campo-input">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name">
        </div>
        <div class="campo-input">
            <label for="email">Seu email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="campo-input">
            <label for="password">Crie uma senha:</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="campo-input">
            <label for="password">Confirme sua senha:</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="campo-input">
            <label for="especialização">Especialização:</label>
            <select name="especialização" id="especialização">
                <option value="matematica">Matemática</option>
                <option value="portugues">Português</option>
                <option value="fisica">Física</option>
                <option value="quimica">Química</option>
                <option value="biologia">Biologia</option>
                <option value="historia">História</option>
                <option value="filosofia">Filosofia</option>
                <option value="sociologia">Sociologia</option>
                <option value="geografia">Geografia</option>
                <option value="artes">Artes</option>
                <option value="ingles">Inglês</option>
            </select>
        </div>
        <div class="row mb-3 justify-content-center">
            <div class="col-12 text-center">
                <input type="submit" name="submit" value="CADASTRAR" class="button">
            </div>
        </div>
        <!--coloquei o style aqui por que no css nao tava funcionando, nao sei pq :p-->
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>