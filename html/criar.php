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
    <link rel="shortcut icon" type="imagex/png" href="../images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">

    <?php include '../php/navbar.php'; ?>
    
        <form method="POST" action="../php/criar_pergunta.php" style="flex-wrap: wrap;">
            <div>
                <h1>Faça aqui a sua pergunta!</h1>
            </div>
            <div class="campo-input">
                <input name="titulo" type="text" class="titulo" placeholder="Título da pergunta" style="border: none; background-color: transparent; width: 360px;" required>
            </div>
            <div class="form-group mb-3">
                <textarea name="descricao" class="form-control" id="descricao-pergunta" rows="8" placeholder="Digite sua dúvida aqui..." required></textarea>
            </div>
            <div class="campo-input">
                <label for="materia">Materia relacionada:</label>
                <select name="materia" id="materia" class="form-select me-2" style="max-width: 250px;" scalerequired>
                    <option value="" disable selected>Selecione a matéria</option>
                    <option value="Matematica">Matemática</option>
                    <option value="Portugues">Português</option>
                    <option value="Fisica">Física</option>
                    <option value="Quimica">Química</option>
                    <option value="Biologia">Biologia</option>
                    <option value="Historia">História</option>
                    <option value="Filosofia">Filosofia</option>
                    <option value="Sociologia">Sociologia</option>
                    <option value="Geografia">Geografia</option>
                    <option value="Artes">Artes</option>
                    <option value="Ingles">Inglês</option>
                </select>
            </div>
            <div class="enviar">
                <button type="submit" name="enviar_pergunta" style="border-radius: 15px;">Enviar</button>
            </div>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>