<?php

include ('conexao.php');
session_start();

//tenho q fazer o bglh se nao aceitar admin mas o login do admin nn ta pronto

if (!isset($_POST['idProfessor']) || !isset($_POST['acao'])) {
    header('Location: ../html/admin.php?status=erro_dados');
    exit();
}

$idProfessor = mysqli_real_escape_string($mysqli, $_POST['idProfessor']);
$acao = $_POST['acao']; // aprovar ou rejeitar
$novo_status = '';
$mensagem_sucesso = '';

// define o novo status baseado na ação
if ($acao === 'aprovar') {
    $novo_status = 'confirmado';
    $mensagem_sucesso = 'Professor aprovado com sucesso!';
} elseif ($acao === 'rejeitar') {
    $novo_status = 'rejeitado';
    $mensagem_sucesso = 'Professor rejeitado com sucesso.';
} else {
    header('Location: ../html/admin.php?status=erro_acao');
    exit();
}

// UPDATE NO BD
$update_query = "
    UPDATE professor 
    SET statusConfirmacao = '$novo_status' 
    WHERE idProfessor = '$idProfessor'
";

if (mysqli_query($mysqli, $update_query)) {
    // manda pro admin
    header('Location: ../html/admin.php?status=sucesso&msg=' . urlencode($mensagem_sucesso));
    exit();
} else {
    // da erro ne
    $erro = urlencode('Erro ao atualizar status: ' . mysqli_error($mysqli));
    header('Location: ../html/admin.php?status=erro_bd&msg=' . $erro);
    exit();
}
?>