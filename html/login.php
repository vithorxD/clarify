                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
<?php

include ('../php/conexao.php');
session_start();

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));

    // RAPAZEADA TIVE QUE USAR INNER JOIN PQP GISELE VOCE ESTARIA ORGULHOSA DE MIM
    $select = mysqli_query($mysqli, 
        "SELECT 
            u.idUsuario, 
            a.idAluno, 
            p.idProfessor
        FROM 
            usuario u
        LEFT JOIN 
            aluno a ON u.idUsuario = a.idUsuario
        LEFT JOIN 
            professor p ON u.idUsuario = p.idUsuario
        WHERE 
            u.email = '$email' AND u.senha = '$senha'") or die('Erro na consulta');

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        
    // salva o id do usuario na sessao
    $_SESSION['user_id'] = $row['idUsuario'];

    // ve se é admin
    if ($row['ehAdmin'] == 1) {
        $_SESSION['user_type'] = 'admin';
        header('Location: ../html/admin.php');
        exit();
    }
        
    // ve se é aluno ou prof e coloca na sessao especifica
    if ($row['idAluno'] !== null) {
        $_SESSION['user_type'] = 'aluno';
        $_SESSION['aluno_id'] = $row['idAluno'];
        header('Location: ../html/home.php');
    } elseif ($row['idProfessor'] !== null) {
        $_SESSION['user_type'] = 'professor';
        $_SESSION['professor_id'] = $row['idProfessor']; 
        header('Location: ../html/home.php');
    } else {
        // só pra ter o else ne nao faz mal nenhum
        header('Location: ../html/home.php');
    }
    exit();
    }else{
        $message[] = 'Email ou senha incorreto(s). Tente novamente.';
    }

    // ve na tabela se ta pendente ou n
    $check_status_query = "SELECT statusConfirmacao FROM professor WHERE idUsuario = '$idUsuario'";
    $status_result = mysqli_query($mysqli, $check_status_query);
    $status_row = mysqli_fetch_assoc($status_result);

    if ($status_row && $status_row['statusConfirmacao'] === 'pendente') {
        //nega o acesso e manda pra salinha
        header('Location: ../html/aguardoprof.php');
        exit();
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
    <form method="POST" action="login.php" style="flex-wrap: wrap;">
        <div class="titulo">
            <h1>Faça seu login</h1>
        </div>
        <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="mensagem">' .$message. '</div>';
                }
            }
        ?>
        <div class="campo-input">
            <label for="email">Seu e-mail:</label>
            <input type="email" name="email" placeholder="Insira seu email" class="box" id="email" required>
        </div>
        <div class="campo-input">
            <label for="senha">Sua senha:</label>
            <input type="password" name="senha" placeholder="Insira seu email" class="box" id="senha" required>
        </div>
        <input class="button" type="submit" name="submit" value="ENTRAR">
        
        <p style="align-self: center;">
            Não tem uma conta? 
            <a href="../html/cadastro.php" style="text-decoration: none; color:#EDF3F8;">Faça seu cadastro!</a>
        </p>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>