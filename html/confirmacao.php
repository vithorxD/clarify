<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link rel="stylesheet" href="../css/confirmacao.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #4989B6;">
    <form action="../php/upload_confirmacao.php" method="post" enctype="multipart/form-data" style="flex-wrap: wrap;">
        <div class="titulo">
            <h1>Precisamos de confirmação!</h1>
        </div>
        <div class="texto" style="align-self: center;">
            <p>Para que tenhamos certeza que você é realmente um professor,
            precisamos de alguma confirmação para permitirmos que você nos ajude.
            Pedimos que mande uma confirmação que mostre que você realmente concluiu 
            o curso profissionalizante para se tornar um professor, usaremos esses dados
            apenas para segurança da nossa empresa e para que nossos usuarios possam ter certeza
            que estão recebendo o conhecimento com credibilidade.</p>
        </div>
        <div campo-input style="align-self: center;">
            <label for="documento">Selecione um arquivo</label>
            <input type="file" name="documento" id="documento" required>
        </div>
        <button type="submit" name="upload_confirmacao" value="CONFIRMAR">CONFIRMAR</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>