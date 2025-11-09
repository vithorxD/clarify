<?php
ob_start(); 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('conexao.php'); 

//ve se o usuario ta logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['erro'] = "Acesso negado. Faça login.";
    header('Location: ../html/login.php'); 
    exit();
}

$idUsuario = $_SESSION['user_id'];

//ve se é prof e ele ta aprovado
$check_professor_query = "
    SELECT 
        idProfessor 
    FROM 
        professor 
    WHERE 
        idUsuario = '$idUsuario' AND statusConfirmacao = 'confirmado'
";

$resultado_prof = mysqli_query($mysqli, $check_professor_query);
$dados_professor = mysqli_fetch_assoc($resultado_prof);

if (!$dados_professor) {
    // se o user nn for prof ou n for aprovado
    $_SESSION['erro'] = "Apenas professores aprovados podem criar exercícios.";
    header('Location: ../html/home.php');
    exit();
}

// pega o id prof
$idProfessor = $dados_professor['idProfessor']; 

// verifica se o form foi enviado
if (isset($_POST['enviar_exercicio'])) {
    
    $titulo = mysqli_real_escape_string($mysqli, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($mysqli, $_POST['descricao']);
    $materia = mysqli_real_escape_string($mysqli, $_POST['materia']);
    
    if (empty($titulo) || empty($descricao) || empty($materia)) {
        $_SESSION['erro'] = "Todos os campos do exercício são obrigatórios!";
        header('Location: ../html/criarE.php');
        exit();
    }
    
    // monta e executa o insert
    $insert_query = "
        INSERT INTO exercicio (idProfessor, titulo, descricao, materia)
        VALUES ('$idProfessor', '$titulo', '$descricao', '$materia')
    ";
    
    if (mysqli_query($mysqli, $insert_query)) {
        $novo_id_exercicio = mysqli_insert_id($mysqli);
        $_SESSION['sucesso'] = "Exercício '$titulo' criado com sucesso!";
        header('Location: ../html/exercicio.php'); 
        exit();
        
    } else {
        $_SESSION['erro'] = 'Erro ao publicar o exercício: ' . mysqli_error($mysqli);
        header('Location: ../html/criarE.php');
        exit();
    }
} else {
    header('Location: ../html/criarE.php');
    exit();
}

ob_end_flush();
?>