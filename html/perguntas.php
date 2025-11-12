<?php
// Arquivo: ../html/perguntas.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('../php/conexao.php'); 

$condicoes = []; // array pra por cada where
$clausula_where = "";

// por materia
if (isset($_GET['materia_filtro']) && !empty($_GET['materia_filtro'])) {
    $materia_selecionada = mysqli_real_escape_string($mysqli, $_GET['materia_filtro']);
    // poe no array
    $condicoes[] = "p.materia = '$materia_selecionada'";
}

// por titulo
if (isset($_GET['termo_pesquisa']) && !empty($_GET['termo_pesquisa'])) {
    $termo = mysqli_real_escape_string($mysqli, $_GET['termo_pesquisa']);
    // adiciona o like no array
    $condicoes[] = "p.titulo LIKE '%$termo%'";
}

// se tiver os dois une
if (!empty($condicoes)) {
    $clausula_where = " WHERE " . implode(" AND ", $condicoes);
}

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
    " . $clausula_where . "  
    ORDER BY 
        p.dataCriacao DESC;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">
    <?php include '../php/navbar.php'; ?>
    <div class="container" style="padding-top: 30px;">

        <h1 class="mb-4 text-center" style="color: #4989B6;">Fórum de Dúvidas Recentes</h1>
        <hr>
        <div class="sla">
            <a href="../html/criar.php"><button class="criar">Faça a sua própria pergunta</button></a>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" action="perguntas.php" class="d-flex">
                    
                    <input 
                        type="text" 
                        name="termo_pesquisa" 
                        class="form-control me-2" 
                        placeholder="Pesquisar por título ou palavra-chave..."
                        value="<?php echo htmlspecialchars($_GET['termo_pesquisa'] ?? ''); ?>"
                    >

                    <select name="materia_filtro" class="form-select me-2" style="max-width: 250px;">
                        <option value="">Todas as Matérias</option>
                        <option value="Matematica" <?php echo (($_GET['materia_filtro'] ?? '') == 'Matematica') ? 'selected' : ''; ?>>Matemática</option>
                        <option value="Portugues" <?php echo (($_GET['materia_filtro'] ?? '') == 'Portugues') ? 'selected' : ''; ?>>Portugues</option>
                        <option value="Fisica" <?php echo (($_GET['materia_filtro'] ?? '') == 'Fisica') ? 'selected' : ''; ?>>Fisica</option>
                        <option value="Quimica" <?php echo (($_GET['materia_filtro'] ?? '') == 'Quimica') ? 'selected' : ''; ?>>Quimica</option>
                        <option value="Biologia" <?php echo (($_GET['materia_filtro'] ?? '') == 'Biologia') ? 'selected' : ''; ?>>Biologia</option>
                        <option value="Historia" <?php echo (($_GET['materia_filtro'] ?? '') == 'Historia') ? 'selected' : ''; ?>>Historia</option>
                        <option value="Filosofia" <?php echo (($_GET['materia_filtro'] ?? '') == 'Filosofia') ? 'selected' : ''; ?>>Filosofia</option>
                        <option value="Sociologia" <?php echo (($_GET['materia_filtro'] ?? '') == 'Sociologia') ? 'selected' : ''; ?>>Sociologia</option>
                        <option value="Geografia" <?php echo (($_GET['materia_filtro'] ?? '') == 'Geografia') ? 'selected' : ''; ?>>Geografia</option>
                        <option value="Artes" <?php echo (($_GET['materia_filtro'] ?? '') == 'Artes') ? 'selected' : ''; ?>>Artes</option>
                        <option value="Ingles" <?php echo (($_GET['materia_filtro'] ?? '') == 'Ingles') ? 'selected' : ''; ?>>Ingles</option>
                        </select>
                    
                    <button type="submit" class="btn btn-primary">
                        Pesquisar
                    </button>
                </form>
            </div>
        </div>
        
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
            
            <div class="row row-cols-1 row-cols-md-2 g-4 h-50">
            <?php foreach ($perguntas as $pergunta): ?>
                <div class="col">
                    <div class="pergunta-card d-flex flex-column h-100">
                        <h3 class="card-title"><?php echo htmlspecialchars($pergunta['titulo']); ?></h3>
                        <p class="card-text">
                                    <?php
                                        // mostra só os primeiros 150 caracteres da descrição
                                        echo htmlspecialchars(substr($pergunta['descricao'], 0, 100));
                                        if (strlen($pergunta['descricao']) > 100) echo '...';
                                    ?>
                                </p>
            
                            <div class="pergunta-info">
                                Postado por: <strong><?php echo htmlspecialchars($pergunta['nome_usuario']); ?></strong> |
                                Matéria: <span class="materia-tag"><?php echo htmlspecialchars($pergunta['materia']); ?></span> |
                                Em: <?php echo date('d/m/Y H:i', strtotime($pergunta['dataCriacao'])); ?>
                            </div>
                        <div class="card-body mt-auto">
                            <a href="visualizar_pergunta.php?id=<?php echo $pergunta['idPerguntas']; ?>" class="responder">Visualizar respostas e responder</a>
                        </div>
                    </div>
            </div>

                <?php endforeach; ?>

            <?php endif; ?>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>