<?php

include ('/xampp/htdocs/clarify/php/conexao.php');

$message = [];

if(isset($_POST['submit'])){

    $nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));
    //csenha é só pra comparacao rpzd nao precisa estar no banco viu :p
    $csenha = mysqli_real_escape_string($mysqli, md5($_POST['csenha']));
    $especializacao = mysqli_real_escape_string($mysqli, $_POST['especializacao']);

    if ($senha != $csenha) {
        $message[] = 'As senhas não coincidem.';
    } else {
        $select = mysqli_query($mysqli, "SELECT * FROM `usuario` WHERE email = '$email'") or die('Erro na consulta de email');

        if(mysqli_num_rows($select) > 0){
            $message[] = 'Já existe um usuário cadastrado com este e-mail.';
        } else {
            $insert_usuario = mysqli_query($mysqli, "INSERT INTO usuario(nome, email, senha) VALUES ('$nome', '$email', '$senha')") or die('Erro na inserção do usuário');
            
            if($insert_usuario){
                
                $idUsuario = mysqli_insert_id($mysqli); 

                // poe na tabela professor com o status pendente pra nn poder logar ate o admin permitir
                $insert_professor = mysqli_query($mysqli, "
                    INSERT INTO professor(idUsuario, especializacao, statusConfirmacao) 
                    VALUES ('$idUsuario', '$especializacao', 'pendente')
                ") or die('Erro na inserção do professor: ' . mysqli_error($mysqli));

                if ($insert_professor) {
                    header('Location: ../html/confirmacao.php');
                    exit();
                } else {
                    mysqli_query($mysqli, "DELETE FROM usuario WHERE idUsuario = '$idUsuario'");
                    $message[] = 'Cadastro de professor falhou. Tente novamente: ' . mysqli_error($mysqli);
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
    <form method="POST" action="cadastroprof.php" style="max-width: 500px; width: 100%;">
        <div class="titulo">
            <h1>Faça seu cadastro</h1>
        </div>
        <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="mensagem">'.$message.'</div>';
                }
            } 
        ?>
        <div class="campo-input">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" placeholder="Insira seu nome" name="nome" required>
        </div>
        <div class="campo-input">
            <label for="email">Seu email:</label>
            <input type="email" id="email" placeholder="Insira seu email" name="email" required>
        </div>
        <div class="campo-input">
            <label for="senha">Crie uma senha:</label>
            <input type="password" id="senha" placeholder="Insira sua senha" name="senha" required>
        </div>
        <div class="campo-input">
            <label for="csenha">Confirme sua senha:</label>
            <input type="password" name="csenha" placeholder="Confirme sua senha" id="csenha" required>
        </div>
        <div class="campo-input">
            <label for="especializacao">Especialização:</label>
            <select name="especializacao" id="especializacao">
                <option value="" disable selected>Selecione sua especialização academica</option>
                <option value="Matematica">Matemática</option>
                <option value="Portugues">Português</option>
                <option value="Física">Física</option>
                <option value="Química">Química</option>
                <option value="Biologia">Biologia</option>
                <option value="História">História</option>
                <option value="Filosofia">Filosofia</option>
                <option value="Sociologia">Sociologia</option>
                <option value="Geografia">Geografia</option>
                <option value="Artes">Artes</option>
                <option value="Ingles">Inglês</option>
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