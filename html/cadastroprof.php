<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #4989B6;">
    <form action="" style="flex-wrap: wrap;">
        <div class="titulo">
            <h1>Faça seu cadastro</h1>
        </div>
        <div class="campo-input">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name">
        </div>
        <div class="campo-input">
            <label for="email">Seu email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="campo-input">
            <label for="password">Crie uma senha:</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="campo-input">
            <label for="password">Confirme sua senha:</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="campo-input">
            <label for="especialização">Especialização:</label>
            <select name="especialização" id="especialização">
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
        <!--coloquei o style aqui por que no css nao tava funcionando, nao sei pq :p-->
        <a href="../html/confirmacao.php" style="text-decoration: none; color: white;" ></a><button>CONFIRMAR</button></a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>