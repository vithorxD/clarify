<?php

include ('../php/conexao.php');
session_start();

if(!isset($_SESSION['user_id']) || !isset($_POST['submit'])){
    header('Location: ../html/login.php');
    exit();
}

$idUsuario = $_SESSION['user_id'];
$tipoUsuario = $_SESSION['user_type']; // Usamos o tipo salvo na sessão

$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$nova_senha = $_POST['nova_senha'];
$confirma_senha = $_POST['confirma_senha'];
$messages = [];

//update dos dados gerais do usuario
$update_usuario_query = "UPDATE usuario SET nome = '$nome', email = '$email'";

// Vverifica se alteraram a senha
if (!empty($nova_senha)) {
    if ($nova_senha !== $confirma_senha) {
        $messages[] = 'A nova senha e a confirmação de senha não coincidem.';
    } else {
        $senha_hash = mysqli_real_escape_string($mysqli, md5($nova_senha));
        $update_usuario_query .= ", senha = '$senha_hash'"; // Adiciona a alteração da senha
    }
}

// finaliza o update
$update_usuario_query .= " WHERE idUsuario = '$idUsuario'";

if (empty($messages)) {
    $update_usuario = mysqli_query($mysqli, $update_usuario_query);
    
    if (!$update_usuario) {
        $messages[] = 'Erro ao atualizar dados gerais: ' . mysqli_error($mysqli);
    } else {
        $messages[] = 'Dados gerais atualizados com sucesso.';
    }
}


//update das informacoes especificas

if ($tipoUsuario == 'aluno') {
    $serie = mysqli_real_escape_string($mysqli, $_POST['serie']);
    $update_aluno_query = "UPDATE aluno SET serie = '$serie' WHERE idUsuario = '$idUsuario'";
    
    $update_aluno = mysqli_query($mysqli, $update_aluno_query);
    
    if (!$update_aluno) {
        $messages[] = 'Erro ao atualizar dados do aluno: ' . mysqli_error($mysqli);
    } else {
        $messages[] = 'Dados específicos de aluno atualizados com sucesso.';
        header('Location: ../html/perfil.php');
        exit();
    }

} elseif ($tipoUsuario == 'professor') {
    $especializacao = mysqli_real_escape_string($mysqli, $_POST['especializacao']);
    
    $update_professor_query = "UPDATE professor SET especializacao = '$especializacao' WHERE idUsuario = '$idUsuario'";

    $update_professor = mysqli_query($mysqli, $update_professor_query);

    if (!$update_professor) {
        $messages[] = 'Erro ao atualizar dados do professor: ' . mysqli_error($mysqli);
    } else {
        $messages[] = 'Dados específicos de professor atualizados com sucesso.';
        header('Location: ../html/perfil.php');
        exit();
    }
}
?>