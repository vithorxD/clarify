<?php
// Arquivo: ../html/visualizar_exercicio.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('../php/conexao.php'); 

// 1. Verifica se o ID do Exercício foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: exercicios.php');
    exit();
}

$id_exercicio = mysqli_real_escape_string($mysqli, $_GET['id']);

// Verifica o ID do usuário logado (se houver)
$idUsuarioLogado = $_SESSION['user_id'] ?? null;
$ehAdmin = $_SESSION['ehAdmin'] ?? 0;

// 2. Busca o Exercício Completo, o Professor que o criou e seu idUsuario
$query_exercicio = "
    SELECT 
        e.idExercicio, 
        e.titulo, 
        e.descricao, 
        e.materia, 
        e.resolucao, 
        e.dataCriacao, 
        p.idUsuario AS idUsuarioProfessor,  -- ID do USUARIO que criou o exercício
        u.nome AS nome_professor
    FROM 
        exercicio e
    JOIN 
        professor p ON e.idProfessor = p.idProfessor
    JOIN 
        usuario u ON p.idUsuario = u.idUsuario
    WHERE 
        e.idExercicio = '$id_exercicio'
";

$resultado_exercicio = mysqli_query($mysqli, $query_exercicio);
$exercicio = mysqli_fetch_assoc($resultado_exercicio);

// Se o exercício não for encontrado
if (!$exercicio) {
    header('Location: exercicios.php');
    exit();
}

// 3. Define a Permissão de Visualização da Resolução
// A permissão é TRUE se:
// a) O usuário logado é o mesmo que criou o exercício.
// b) O usuário logado é um Administrador (ehAdmin = 1).
$pode_ver_resolucao = false;
if ($idUsuarioLogado) {
    // Verifica se o ID do professor é o mesmo ID do usuário logado
    if ($idUsuarioLogado == $exercicio['idUsuarioProfessor']) {
        $pode_ver_resolucao = true;
    }
    // Verifica se é administrador
    if ($ehAdmin == 1) {
        $pode_ver_resolucao = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($exercicio['titulo']); ?> - Exercício</title>
    <link rel="stylesheet" href="../css/visualizar_exercicio.css">
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #EDF3F8;">
    
    <?php include '../php/navbar.php'; ?>
    
    <div class="container" style="padding-top: 30px;">

        <div class="exercicio-view">
            <h1><?php echo htmlspecialchars($exercicio['titulo']); ?></h1>
            <p class="lead">Matéria: <span class="badge bg-success"><?php echo htmlspecialchars($exercicio['materia']); ?></span></p>
            <hr>
            
            <h2>Enunciado e Instruções</h2>
            <p><?php echo nl2br(htmlspecialchars($exercicio['descricao'])); ?></p>
            
            <hr>
            <small class="text-muted">
                Criado por: <strong><?php echo htmlspecialchars($exercicio['nome_professor']); ?></strong> 
                Em: <?php echo date('d/m/Y H:i', strtotime($exercicio['dataCriacao'])); ?>
            </small>
        </div>
        
        <h2 class="mt-5">Resolução Oficial</h2>

        <?php if ($pode_ver_resolucao): ?>
            <div class="resolucao-card">
                <h2>Conteúdo da Resolução</h2>
                <p><?php echo nl2br(htmlspecialchars($exercicio['resolucao'])); ?></p>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                A resolução oficial deste exercício está restrita. Apenas o professor que criou ou o administrador podem visualizá-la.
            </div>
        <?php endif; ?>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>