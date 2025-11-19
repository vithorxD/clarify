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
    <link rel="icon" type="imagex/png" href="../images/clarifyFinal.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background-color: #EDF3F8;">

    <?php include '../php/navbar.php'; ?>

    <form method="POST" action="../php/criar_exercicio.php" style="flex-wrap: wrap;">
        <div>
            <h1>Ajude os alunos com exercícios para treinar!</h1>
        </div>
        <div class="campo-input">
            <input name="titulo" type="text" class="titulo" name="titulo" placeholder="Título do exercício" style="border: none; background-color:transparent; width: 300px;" required>
        </div>
        <div class="form-group mb-3">
            <textarea type="text" class="form-control" rows="5" cols="90" name="descricao" placeholder="Descreva a atividade aqui" required></textarea>
        </div>
        <div class="form-group mb-3">
            <textarea type="text" class="form-control" rows="5" cols="90" name="resolucao" placeholder="Explique a resolução aqui" required></textarea>
        </div>
        <div class="campo-input">
            <label for="materia">Materia relacionada:</label>
            <select name="materia" id="materia" class="form-select me-2" style="max-width: 250px;" required>
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
            <button type="submit" name="enviar_exercicio" style="border-radius: 15px">Enviar</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>