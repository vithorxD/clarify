<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('../php/conexao.php'); 

//procura as perguntas
$query_perguntas = "
    SELECT 
        p.idPerguntas, 
        p.titulo, 
        p.descricao, 
        p.materia, 
        p.dataCriacao, 
        u.nome AS nome_usuario
    FROM 
        perguntas p
    JOIN 
        usuario u ON p.idUsuario = u.idUsuario
    ORDER BY 
        p.dataCriacao DESC
    LIMIT 20;               
";

$resultado_perguntas = mysqli_query($mysqli, $query_perguntas) or die('Erro ao buscar perguntas: ' . mysqli_error($mysqli));

$perguntas = mysqli_fetch_all($resultado_perguntas, MYSQLI_ASSOC);

$erro = null;
if (isset($_SESSION['erro'])) {
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/perguntas.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">
    <?php include '../php/navbar.php'; ?>
    <div class="container" style="padding-top: 30px;">
        
        <h1 class="mb-4 text-center" style="color: #4989B6;">Fórum de Dúvidas Recentes</h1>
        
        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert">
                Erro ao criar pergunta: <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($perguntas)): ?>
            <div class="alert alert-info text-center">
                Ainda não há perguntas publicadas. Seja o primeiro a perguntar! 
                <a href="../html/criar.php">Criar Pergunta</a>
            </div>
        <?php else: ?>
            
            <?php foreach ($perguntas as $pergunta): ?>
                <a href="visualizar_pergunta.php?id=<?php echo $pergunta['idPerguntas']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="pergunta-card">
                        <h3><?php echo htmlspecialchars($pergunta['titulo']); ?></h3>
                        <p><?php 
                            // mostra só os primeiros 150 caracteres da descrição
                            echo htmlspecialchars(substr($pergunta['descricao'], 0, 150)); 
                            if (strlen($pergunta['descricao']) > 150) echo '...';
                        ?></p>
                        <div class="pergunta-info">
                            Postado por: <strong><?php echo htmlspecialchars($pergunta['nome_usuario']); ?></strong> | 
                            Matéria: <span class="materia-tag"><?php echo htmlspecialchars($pergunta['materia']); ?></span> | 
                            Em: <?php echo date('d/m/Y H:i', strtotime($pergunta['dataCriacao'])); ?>
                            <br>
                            <small class="text-primary">Clique para ver respostas e responder.</small>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>

        <?php endif; ?>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>