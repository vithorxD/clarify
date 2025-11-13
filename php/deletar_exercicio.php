<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('conexao.php'); 


if (!isset($_SESSION['user_id'])) {
    $_SESSION['erro'] = "Você precisa estar logado para realizar esta ação.";
    header('Location: ../html/login.php');
    exit();
}

$idUsuarioLogado = $_SESSION['user_id'];
$ehAdminLogado = isset($_SESSION['ehAdmin']) ? $_SESSION['ehAdmin'] : 0; 


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['erro'] = "ID de exercício inválido.";
    header('Location: ../html/exercicio.php');
    exit();
}
$idExercicio = mysqli_real_escape_string($mysqli, $_GET['id']);


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


$isAutor = ($exercicioAutor && $exercicioAutor['idUsuario'] == $idUsuarioLogado);
$isAdmin = ($ehAdminLogado == 1);

if (!$exercicioAutor || (!$isAutor && !$isAdmin)) {

    $_SESSION['erro'] = "Você não tem permissão para excluir este exercício.";
    header('Location: ../html/exercicio.php');
    exit();
}

$delecaoSucesso = true;



if ($delecaoSucesso) {
    $deleteExercicio = "DELETE FROM exercicio WHERE idExercicio = '$idExercicio'";
    if (mysqli_query($mysqli, $deleteExercicio)) {
        

        $_SESSION['sucesso'] = "O exercício foi excluído com sucesso.";
        header('Location: ../html/exercicio.php'); // Redireciona para a lista de exercícios
        exit();
        
    } else {

        $_SESSION['erro'] = "Erro ao excluir o exercício: " . mysqli_error($mysqli);
    }
}

header('Location: ../html/exercicio.php');
exit();

?>