<?php

include ('conexao.php');
session_start();

//ve se é o admin q ta logado
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../html/login.php');
    exit();
}

if (isset($_POST['acao'], $_POST['idProfessor'])) {
    
    $idProfessor = mysqli_real_escape_string($mysqli, $_POST['idProfessor']);
    $acao = $_POST['acao'];
    
    //isso q define o novo status e permite o prof logar
    if ($acao === 'aprovar') {
        $novo_status = 'confirmado';
        $msg_log = 'aprovado';
    } elseif ($acao === 'rejeitar') {
        $novo_status = 'rejeitado';
        $msg_log = 'rejeitado';
    } else {
        header('Location: ../html/admin.php');
        exit();
    }
    
    // atualiza no bd
    $update_query = "
        UPDATE professor 
        SET statusConfirmacao = '$novo_status' 
        WHERE idProfessor = '$idProfessor'
    ";
    
    if (mysqli_query($mysqli, $update_query)) {
        $_SESSION['admin_message'] = "Professor ID $idProfessor foi $msg_log com sucesso.";
    } else {
        $_SESSION['admin_message'] = "Erro ao atualizar o professor ID $idProfessor: " . mysqli_error($mysqli);
    }
}
header('Location: ../html/admin.php');
exit();
?>