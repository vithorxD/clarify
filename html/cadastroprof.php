<?php

include '../php/conexao.php';
session_start();

$messages = [];

if(isset($_POST['submit'])){
    $nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, md5($_POST['senha'])); 
    $csenha = mysqli_real_escape_string($mysqli, md5($_POST['csenha'])); 
    $especializacao = mysqli_real_escape_string($mysqli, $_POST['especializacao']);
    
    if($senha !== $csenha){
        $messages[] = 'As senhas não coincidem!';
    }
    
    $select = mysqli_query($mysqli, "SELECT idUsuario FROM usuario WHERE email = '$email'") or die('Erro na verificação de e-mail');
    
    if(mysqli_num_rows($select) > 0){
        $messages[] = 'Já existe um usuário cadastrado com este e-mail.';
    }
    
    if (empty($messages)) {
        
        // coloca tudo no usuario
        $insert_usuario_query = "INSERT INTO usuario(nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        $insert_usuario = mysqli_query($mysqli, $insert_usuario_query);
        
        if($insert_usuario){
            // obtem o id do usuario recem criado
            $idUsuario = mysqli_insert_id($mysqli); 

            // poe as especificacoes no prof 
            $insert_professor_query = "
                INSERT INTO professor(idUsuario, especializacao, statusConfirmacao) 
                VALUES ('$idUsuario', '$especializacao', 'pendente')
            ";
            $insert_professor = mysqli_query($mysqli, $insert_professor_query);

            if($insert_professor){
                // manda pra pagina de confirmaçao
                header('Location: ../html/confirmacao.php');
                exit();
            } else {
                // apaga o cadastro do banco se deu erro
                mysqli_query($mysqli, "DELETE FROM usuario WHERE idUsuario = '$idUsuario'");
                $messages[] = 'Erro ao finalizar o cadastro do professor. Tente novamente: ' . mysqli_error($mysqli);
            }
        } else {
            $messages[] = 'Erro ao criar o usuário: ' . mysqli_error($mysqli);
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
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome">
        </div>
        <div class="campo-input">
            <label for="email">Seu email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="campo-input">
            <label for="senha">Crie uma senha:</label>
            <input type="password" id="senha" name="senha">
        </div>
        <div class="campo-input">
            <label for="csenha">Confirme sua senha:</label>
            <input type="password" name="csenha" id="csenha">
        </div>
        <div class="campo-input">
            <label for="especializacao">Especialização:</label>
            <select name="especializacao" id="especializacao">
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