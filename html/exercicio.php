<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../php/conexao.php');

$condicoes = []; // array pra por cada where
$clausula_where = "";

// por materia
if (isset($_GET['materia_filtro']) && !empty($_GET['materia_filtro'])) {
    $materia_selecionada = mysqli_real_escape_string($mysqli, $_GET['materia_filtro']);
    // poe no array
    $condicoes[] = "e.materia = '$materia_selecionada'";
}

// por titulo
if (isset($_GET['termo_pesquisa']) && !empty($_GET['termo_pesquisa'])) {
    $termo = mysqli_real_escape_string($mysqli, $_GET['termo_pesquisa']);
    // adiciona o like no array
    $condicoes[] = "e.titulo LIKE '%$termo%'";
}

// se tiver os dois une
if (!empty($condicoes)) {
    $clausula_where = " WHERE " . implode(" AND ", $condicoes);
}

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
        professor pr ON e.idProfessor = pr.idProfessor
    JOIN    
        usuario u ON pr.idUsuario = u.idUsuario
    " . $clausula_where . "  
    ORDER BY 
        e.dataCriacao DESC;
";

$resultado_exercicios = mysqli_query($mysqli, $query_exercicios) or die('Erro ao buscar exercícios: ' . mysqli_error($mysqli));

$exercicios = mysqli_fetch_all($resultado_exercicios, MYSQLI_ASSOC);

//ve se sim ou nao
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

        <h1 class="mb-4 text-center" style="color: #142633;">Caderno de Exercícios</h1>
        <hr>
        <div class="sla">
            <a href="../html/criarE.php"><button class="criar">Ajude os alunos a estudarem com exercícios feitos por você!</button></a>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <form  method="GET" action="exercicio.php" class="d-flex">
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
                    
                    <button type="submit" class="btn btn-primary pesquisar" style="background-color: #699EC3; border: none; border-radius: 10px;">Pesquisar</button>
                </form>
            </div>
        </div>

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

            <div class="row row-cols-1 row-cols-md-2 g-4 h-50">
            <?php foreach ($exercicios as $exercicio): ?>
                <div class="col">
                    <div class="exercicio-card d-flex flex-column h-100">
                        <h3 class="card-title"><?php echo htmlspecialchars($exercicio['titulo']); ?></h3>
                        <p class="card-text"><?php
                            echo htmlspecialchars(substr($exercicio['descricao'], 0, 100));
                            if (strlen($exercicio['descricao']) > 100) echo '...';
                            ?></p>
                        <div class="exercicio-info">
                            Criado por: <strong><?php echo htmlspecialchars($exercicio['nome_professor']); ?></strong> |
                            Matéria: <span class="materia-tag-exercicio"><?php echo htmlspecialchars($exercicio['materia']); ?></span> |
                            Em: <?php echo date('d/m/Y H:i', strtotime($exercicio['dataCriacao'])); ?>
                        </div>
                        <div class="card-body mt-auto">
                            <a style="margin-top: 10px;" href="visualizar_exercicio.php?id=<?php echo $exercicio['idExercicio']; ?>" style="text-decoration: none; color: inherit;" class="visualizar">Ver exercício e resolução</a>
                        </div>
                    </div>
            </div>
            <?php endforeach; ?>

        <?php endif; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>