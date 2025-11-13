<?php

include ('conexao.php'); 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.php');
    exit();
}

$idUsuario = $_SESSION['user_id'];
$delecaoSucesso = true;

$queryTipo = "
    SELECT 
        CASE 
            WHEN EXISTS (SELECT 1 FROM aluno WHERE idUsuario = '$idUsuario') THEN 'aluno'
            WHEN EXISTS (SELECT 1 FROM professor WHERE idUsuario = '$idUsuario') THEN 'professor'
            ELSE NULL 
        END AS tipo
";
$resultadoTipo = mysqli_query($mysqli, $queryTipo);
$tipoUsuario = mysqli_fetch_assoc($resultadoTipo)['tipo'];


if ($tipoUsuario === 'professor') {
    
    $deleteExercicios = "
        DELETE e FROM exercicio e 
        JOIN professor p ON e.idProfessor = p.idProfessor
        WHERE p.idUsuario = '$idUsuario'
    ";
    if (!mysqli_query($mysqli, $deleteExercicios)) {
        $delecaoSucesso = false;
    }

    if ($delecaoSucesso) {
        $deleteFilha = "DELETE FROM professor WHERE idUsuario = '$idUsuario'";
        if (!mysqli_query($mysqli, $deleteFilha)) {
            $delecaoSucesso = false;
        }
    }
} 

elseif ($tipoUsuario === 'aluno') {

    $deleteFilha = "DELETE FROM aluno WHERE idUsuario = '$idUsuario'";
    if (!mysqli_query($mysqli, $deleteFilha)) {
        $delecaoSucesso = false;
    }
}

if ($delecaoSucesso) {
    
    $deleteRespostas = "DELETE FROM respostas WHERE idUsuario = '$idUsuario'";
    if (!mysqli_query($mysqli, $deleteRespostas)) {
        $delecaoSucesso = false;
    }
}

if ($delecaoSucesso) {
    
    $deletePerguntas = "DELETE FROM perguntas WHERE idUsuario = '$idUsuario'";
    if (!mysqli_query($mysqli, $deletePerguntas)) {
        $delecaoSucesso = false;
    }
}

if ($delecaoSucesso) {
    $deletePai = "DELETE FROM usuario WHERE idUsuario = '$idUsuario'";
    if (mysqli_query($mysqli, $deletePai)) {
        
        session_destroy();
        header('Location: ../html/login.php?message=Sua conta foi deletada com sucesso.'); 
        exit();
    } else {
        $delecaoSucesso = false;
    }
}

if (!$delecaoSucesso) {
    error_log("Erro crítico ao deletar conta do usuário $idUsuario: " . mysqli_error($mysqli));

    $_SESSION['error_message'] = "Erro crítico. Não foi possível deletar a conta. Tente novamente mais tarde.";
    header('Location: ../html/perfil.php'); 
    exit();
}