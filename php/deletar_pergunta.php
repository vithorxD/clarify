<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('conexao.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.php');
    exit();
}

$idUsuarioLogado = $_SESSION['user_id'];
$ehAdminLogado = isset($_SESSION['ehAdmin']) ? $_SESSION['ehAdmin'] : 0; // Pega o status Admin da sessão

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['erro'] = "ID de pergunta inválido.";
    header('Location: ../html/perguntas.php');
    exit();
}
$idPergunta = mysqli_real_escape_string($mysqli, $_GET['id']);

$queryVerifica = "SELECT idUsuario FROM perguntas WHERE idPerguntas = '$idPergunta'";
$resultadoVerifica = mysqli_query($mysqli, $queryVerifica);
$pergunta = mysqli_fetch_assoc($resultadoVerifica);

$isAutor = ($pergunta && $pergunta['idUsuario'] == $idUsuarioLogado);
$isAdmin = ($ehAdminLogado == 1);

if (!$pergunta || (!$isAutor && !$isAdmin)) {
    $_SESSION['erro'] = "Você não tem permissão para excluir esta pergunta.";
    header('Location: ../html/perguntas.php');
    exit();
}

$deleteRespostas = "DELETE FROM respostas WHERE idPerguntas = '$idPergunta'";
if (mysqli_query($mysqli, $deleteRespostas)) {

    $deletePergunta = "DELETE FROM perguntas WHERE idPerguntas = '$idPergunta'";
    if (mysqli_query($mysqli, $deletePergunta)) {

        $_SESSION['sucesso'] = "A pergunta foi excluída com sucesso.";
        header('Location: ../html/perguntas.php');
        exit();
        
    } else {
        $_SESSION['erro'] = "Erro ao excluir a pergunta: " . mysqli_error($mysqli);
    }
} else {
    $_SESSION['erro'] = "Erro ao excluir as respostas da pergunta: " . mysqli_error($mysqli);
}

header('Location: ../html/perguntas.php');
exit();

?>