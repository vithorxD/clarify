                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
<?php

include ('../php/conexao.php');
session_start();

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $senha = mysqli_real_escape_string($mysqli, md5($_POST['senha'])); 

    // procura na tabela de usuario
    $select = mysqli_query($mysqli, "
        SELECT 
            u.idUsuario, 
            u.ehAdmin 
        FROM 
            usuario u 
        WHERE 
            u.email = '$email' AND u.senha = '$senha'
    ") or die('Erro na consulta de login: ' . mysqli_error($mysqli));

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        
        $_SESSION['user_id'] = $row['idUsuario'];
        $idUsuario = $row['idUsuario'];

        // ADMIN
        if ($row['ehAdmin'] == 1) {
            $_SESSION['user_type'] = 'admin';
            header('Location: ../html/admin.php');
            exit();
        } 
        
        // 3. PROF
        $check_professor_query = mysqli_query($mysqli, "
            SELECT 
                cp.statusConfirmacao 
            FROM 
                professor cp 
            WHERE 
                cp.idUsuario = '$idUsuario'
        ");

        if (mysqli_num_rows($check_professor_query) > 0) {
            $prof_row = mysqli_fetch_assoc($check_professor_query);
            $status = $prof_row['statusConfirmacao'];
            
            $_SESSION['user_type'] = 'professor';

            if ($status === 'pendente') {
                // manda pra confirmaçao ate o admin aceitar
                header('Location: ../html/aguardando_confirmacao.php'); 
                exit();
            } elseif ($status === 'confirmado') {
                // pode entrar colega
                header('Location: ../html/home.php');
                exit();
            }
        }
        
        // ALUNO
        $check_aluno_query = mysqli_query($mysqli, "
            SELECT 
                ca.idAluno 
            FROM 
                aluno ca 
            WHERE 
                ca.idUsuario = '$idUsuario'
        ");

        if (mysqli_num_rows($check_aluno_query) > 0) {
            $_SESSION['user_type'] = 'aluno';
            header('Location: ../html/home.php');
            exit();
        } 
        
    } else {
        $message[] = 'Email ou senha incorreto(s). Tente novamente.';
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