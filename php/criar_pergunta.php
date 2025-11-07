<?php

include ('conexao.php'); 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.php'); 
    exit();
}

// ve se o formulario foi submetido
if (isset($_POST['enviar_pergunta'])) {
    
    //pega o id do cara q perguntou
    $idUsuario = $_SESSION['user_id'];
    
    $titulo = mysqli_real_escape_string($mysqli, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($mysqli, $_POST['descricao']);
    $materia = mysqli_real_escape_string($mysqli, $_POST['materia']);
    
    if (empty($titulo) || empty($descricao) || empty($materia)) {
        $_SESSION['erro'] = "Todos os campos são obrigatórios!";
        header('Location: ../html/criar.php');
        exit();
    }
    
    // monta e faz o insert
    $insert_query = "
        INSERT INTO perguntas (idUsuario, titulo, descricao, materia)
        VALUES ('$idUsuario', '$titulo', '$descricao', '$materia')
    ";
    
    if (mysqli_query($mysqli, $insert_query)) {
        header('Location: ../html/perguntas.php'); 
        exit();
    } else {
        $_SESSION['erro'] = 'Erro ao publicar a pergunta: ' . mysqli_error($mysqli);
        header('Location: ../html/criar.php');
        exit();
    }
} else {
    header('Location: ../html/criar.php');
    exit();
}

?>