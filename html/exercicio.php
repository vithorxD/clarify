<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../php/conexao.php');

// busca todos os exercicios no banco
$query_exercicios = "
    SELECT 
        e.idExercicio, 
        e.titulo, 
        e.descricao, 
        e.materia, 
        e.dataCriacao, 
        u.nome AS nome_professor
        FROM 
        exercicio e
    JOIN 
        professor p ON e.idProfessor = p.idProfessor
    JOIN 
        usuario u ON p.idUsuario = u.idUsuario
    ORDER BY 
        e.dataCriacao DESC
";

$resultado_exercicios = mysqli_query($mysqli, $query_exercicios) or die('Erro ao buscar exercícios: ' . mysqli_error($mysqli));

$exercicios = mysqli_fetch_all($resultado_exercicios, MYSQLI_ASSOC);

// 2. Verifica mensagens de status (sucesso/erro) do processamento
$status_msg = null;
if (isset($_SESSION['sucesso'])) {
    $status_msg = ['tipo' => 'success', 'mensagem' => $_SESSION['sucesso']];
    unset($_SESSION['sucesso']);
} elseif (isset($_SESSION['erro'])) {
    $status_msg = ['tipo' => 'danger', 'mensagem' => $_SESSION['erro']];
    unset($_SESSION['erro']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/exercicio.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background-color: #EDF3F8;">
    <?php include '../php/navbar.php'; ?>
    <div class="container" style="padding-top: 30px;">

        <h1 class="mb-4 text-center" style="color: #28a745;">Caderno de Exercícios</h1>

        <?php if ($status_msg): ?>
            <div class="alert alert-<?php echo $status_msg['tipo']; ?>" role="alert">
                <?php echo htmlspecialchars($status_msg['mensagem']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($exercicios)): ?>
            <div class="alert alert-info text-center">
                Ainda não há exercícios publicados.
            </div>
        <?php else: ?>

            <?php foreach ($exercicios as $exercicio): ?>
                <a href="visualizar_exercicio.php?id=<?php echo $exercicio['idExercicio']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="exercicio-card">
                        <h3><?php echo htmlspecialchars($exercicio['titulo']); ?></h3>
                        <p><?php
                            // Exibe uma prévia da descrição/instruções
                            echo htmlspecialchars(substr($exercicio['descricao'], 0, 150));
                            if (strlen($exercicio['descricao']) > 150) echo '...';
                            ?></p>
                        <div class="exercicio-info">
                            Criado por: <strong><?php echo htmlspecialchars($exercicio['nome_professor']); ?></strong> |
                            Matéria: <span class="materia-tag-exercicio"><?php echo htmlspecialchars($exercicio['materia']); ?></span> |
                            Em: <?php echo date('d/m/Y H:i', strtotime($exercicio['dataCriacao'])); ?>
                            <br>
                            <small class="text-primary">Clique para ver o exercício completo.</small>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>

        <?php endif; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>