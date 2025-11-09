<?php

include ('../php/conexao.php'); 
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/criar.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">

    <?php include '../php/navbar.php'; ?>
    
        <form method="POST" action="../php/criar_pergunta.php" style="flex-wrap: wrap;">
            <div>
                <h1>Faça aqui a sua pergunta!</h1>
            </div>
            <div class="campo-input">
                <input name= "titulo" type="text" class="titulo" placeholder="Título da pergunta" required>
            </div>
            <div class="campo-input">
                <input name="descricao" type="text" class="descricao" placeholder="Descreva sua dúvida aqui" required>
            </div>
            <div class="campo-input">
                <label for="materia">Materias relacionadas:</label>
                <select name="materia" id="materia" required>
                    <option value="" disable selected>Selecione a materia</option>
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
                <button type="submit" name="enviar_pergunta">Enviar</button></a>
            </div>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>