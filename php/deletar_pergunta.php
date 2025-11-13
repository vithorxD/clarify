<?php
// Arquivo: ../php/deletar_pergunta.php
// Processa a deleção de uma pergunta, permitindo exclusão pelo autor ou por um administrador.

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('conexao.php'); 

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.php');
    exit();
}

$idUsuarioLogado = $_SESSION['user_id'];
$ehAdminLogado = isset($_SESSION['ehAdmin']) ? $_SESSION['ehAdmin'] : 0; // Pega o status Admin da sessão

// 2. Obter e validar o ID da pergunta
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['erro'] = "ID de pergunta inválido.";
    header('Location: ../html/perguntas.php');
    exit();
}
$idPergunta = mysqli_real_escape_string($mysqli, $_GET['id']);

// 3. Obter o ID do autor para verificar permissão
$queryVerifica = "SELECT idUsuario FROM perguntas WHERE idPerguntas = '$idPergunta'";
$resultadoVerifica = mysqli_query($mysqli, $queryVerifica);
$pergunta = mysqli_fetch_assoc($resultadoVerifica);

// 4. Verificar permissão (Segurança Crítica)
$isAutor = ($pergunta && $pergunta['idUsuario'] == $idUsuarioLogado);
$isAdmin = ($ehAdminLogado == 1);

if (!$pergunta || (!$isAutor && !$isAdmin)) {
    // Se a pergunta não existe OU o usuário não é autor E nem administrador
    $_SESSION['erro'] = "Você não tem permissão para excluir esta pergunta.";
    header('Location: ../html/perguntas.php');
    exit();
}

// 5. Deleção em Cascata Manual
// Ordem: Respostas (filha) -> Pergunta (pai)

// 5.1. Deletar as respostas associadas (se houver)
$deleteRespostas = "DELETE FROM respostas WHERE idPerguntas = '$idPergunta'";
if (mysqli_query($mysqli, $deleteRespostas)) {
    
    // 5.2. Deletar a pergunta
    $deletePergunta = "DELETE FROM perguntas WHERE idPerguntas = '$idPergunta'";
    if (mysqli_query($mysqli, $deletePergunta)) {
        
        // Sucesso
        $_SESSION['sucesso'] = "A pergunta foi excluída com sucesso.";
        header('Location: ../html/perguntas.php');
        exit();
        
    } else {
        // Erro na deleção da pergunta
        $_SESSION['erro'] = "Erro ao excluir a pergunta: " . mysqli_error($mysqli);
    }
} else {
    // Erro na deleção das respostas
    $_SESSION['erro'] = "Erro ao excluir as respostas da pergunta: " . mysqli_error($mysqli);
}

// Redireciona em caso de erro no processo de exclusão
header('Location: ../html/perguntas.php');
exit();

?>