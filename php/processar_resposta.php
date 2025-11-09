<?php
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('conexao.php'); 
if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.php'); 
    exit();
}

if (isset($_POST['enviar_resposta'])) {
    
    $idUsuario = $_SESSION['user_id'];
    $id_pergunta = mysqli_real_escape_string($mysqli, $_POST['id_pergunta']);
    $conteudo = mysqli_real_escape_string($mysqli, $_POST['conteudo_resposta']);
    
    if (empty($conteudo) || empty($id_pergunta)) {
        // Redireciona para a pergunta com um erro na sessão
        $_SESSION['erro'] = "A resposta não pode estar vazia.";
        header('Location: ../html/visualizar_pergunta.php?id=' . $id_pergunta);
        exit();
    }
    
    // Insere a resposta
    $insert_query = "
        INSERT INTO respostas (idUsuario, idPerguntas, conteudo)
        VALUES ('$idUsuario', '$id_pergunta', '$conteudo')
    ";
    
    if (mysqli_query($mysqli, $insert_query)) {
        $_SESSION['sucesso_resposta'] = "Sua resposta foi enviada com sucesso!";
        header('Location: ../html/visualizar_pergunta.php?id=' . $id_pergunta);
        exit();
    } else {
        $_SESSION['erro'] = 'Erro ao salvar a resposta: ' . mysqli_error($mysqli);
        header('Location: ../html/visualizar_pergunta.php?id=' . $id_pergunta);
        exit();
    }
} else {
    // Acesso direto, redireciona para a lista de perguntas
    header('Location: ../html/perguntas.php');
    exit();
}

ob_end_flush();
?>