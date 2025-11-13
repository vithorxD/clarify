<?php
// Arquivo: ../php/deletar_exercicio.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('conexao.php'); 

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['erro'] = "Você precisa estar logado para realizar esta ação.";
    header('Location: ../html/login.php');
    exit();
}

$idUsuarioLogado = $_SESSION['user_id'];
$ehAdminLogado = isset($_SESSION['ehAdmin']) ? $_SESSION['ehAdmin'] : 0; 

// 2. Obter e validar o ID do exercício
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['erro'] = "ID de exercício inválido.";
    header('Location: ../html/exercicio.php');
    exit();
}
$idExercicio = mysqli_real_escape_string($mysqli, $_GET['id']);

// 3. Obter o ID do Usuário (Autor) para verificar a permissão
$queryVerifica = "
    SELECT 
        u.idUsuario 
    FROM 
        exercicio e
    JOIN 
        professor p ON e.idProfessor = p.idProfessor
    JOIN
        usuario u ON p.idUsuario = u.idUsuario
    WHERE 
        e.idExercicio = '$idExercicio'
";
$resultadoVerifica = mysqli_query($mysqli, $queryVerifica);
$exercicioAutor = mysqli_fetch_assoc($resultadoVerifica);

// 4. Verificar permissão (Segurança Crítica)
$isAutor = ($exercicioAutor && $exercicioAutor['idUsuario'] == $idUsuarioLogado);
$isAdmin = ($ehAdminLogado == 1);

if (!$exercicioAutor || (!$isAutor && !$isAdmin)) {
    // Se o exercício não existe OU o usuário não é autor E nem administrador
    $_SESSION['erro'] = "Você não tem permissão para excluir este exercício.";
    header('Location: ../html/exercicio.php');
    exit();
}

// 5. Deleção em Cascata Manual e Deleção do Exercício
$delecaoSucesso = true;

// 5.1. [OPCIONAL] Se houverem tabelas filhas do exercício (ex: respostas, arquivos), delete-as AQUI:
/*
$deleteRespostasExercicio = "DELETE FROM respostas_exercicio WHERE idExercicio = '$idExercicio'";
if (!mysqli_query($mysqli, $deleteRespostasExercicio)) {
     $_SESSION['erro'] = "Erro ao deletar respostas do exercício: " . mysqli_error($mysqli);
     $delecaoSucesso = false;
}
*/

// 5.2. Deletar o exercício (tabela pai)
if ($delecaoSucesso) {
    $deleteExercicio = "DELETE FROM exercicio WHERE idExercicio = '$idExercicio'";
    if (mysqli_query($mysqli, $deleteExercicio)) {
        
        // Sucesso
        $_SESSION['sucesso'] = "O exercício foi excluído com sucesso.";
        header('Location: ../html/exercicio.php'); // Redireciona para a lista de exercícios
        exit();
        
    } else {
        // Erro na deleção do exercício
        $_SESSION['erro'] = "Erro ao excluir o exercício: " . mysqli_error($mysqli);
    }
}

// Redireciona em caso de erro
header('Location: ../html/exercicio.php');
exit();

?>