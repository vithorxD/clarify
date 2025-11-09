<?php

include('../php/conexao.php');
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/criarE.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background-color: #EDF3F8;">

    <?php include '../php/navbar.php'; ?>

    <form method="POST" action="../php/criar_exercicio.php" style="flex-wrap: wrap;">
        <div>
            <h1>Ajude os alunos com exercícios para treinar!</h1>
        </div>
        <div class="campo-input">
            <input type="text" class="titulo" placeholder="Título do exercício" required>
        </div>
        <div class="campo-input">
            <input type="text" class="descricao" placeholder="Descreva a atividade aqui" required>
        </div>
        <div class="campo-input">
            <input type="text" class="resposta" placeholder="Explique a resolução aqui" required>
        </div>
        <div class="campo-input">
            <label for="filtro">Materias relacionadas:</label>
            <select name="filtro" id="filtro" required>
                <option value="" disabled selected>Selecione a matéria</option>
                <option value="matematica">Matemática</option>
                <option value="portugues">Português</option>
                <option value="fisica">Física</option>
                <option value="quimica">Química</option>
                <option value="biologia">Biologia</option>
                <option value="historia">História</option>
                <option value="filosofia">Filosofia</option>
                <option value="sociologia">Sociologia</option>
                <option value="geografia">Geografia</option>
                <option value="artes">Artes</option>
                <option value="ingles">Inglês</option>
            </select>
        </div>
        <div class="enviar">
            <a href="#"><button>Enviar</button></a>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>