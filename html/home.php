<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include ('../php/conexao.php'); 

$idUsuario = $_SESSION['user_id'] ?? null;

if (!$idUsuario) {
    $tipoUsuario = '';
} else {
    $query = "
        SELECT 
            a.serie,
            p.especializacao
        FROM 
            usuario u
        LEFT JOIN 
            aluno a ON u.idUsuario = a.idUsuario
        LEFT JOIN 
            professor p ON u.idUsuario = p.idUsuario
        WHERE 
            u.idUsuario = '$idUsuario'
    ";
    
    $resultado = mysqli_query($mysqli, $query);
    $usuario = mysqli_fetch_assoc($resultado);

    $tipoUsuario = ''; 
    if ($usuario && $usuario['serie'] !== null) {
        $tipoUsuario = 'aluno';
    } elseif ($usuario && $usuario['especializacao'] !== null) {
        $tipoUsuario = 'professor';
    }
}
    $_SESSION['user_type'] = $tipoUsuario; 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">
    
   <?php include '../php/navbar.php'; ?>

    <div data-bs-spy="scroll" data-bs-target="#navbar2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0" **data-bs-offset="70"**>
        <h1 id="introducao">Sane suas dúvidas!</h1>
        <p class="texto">Um site onde professores e alunos se ajudam para clarear seus estudos.</br>Mande sua pergunta como aluno, ou ajude como professor! De graça!</p>
        <h5 class="moira">"A sabedoria é a própria recompensa."</h5>
        <div class="container-fluid px-0 mt-4 mb-3"> 
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-start ms-30-md mb-2 mb-md-4">

            <?php if ($tipoUsuario == 'aluno'): ?>   
                <button class="criar" type="button">
                        <a href="../html/criar.php">Faça a sua pergunta aqui!</a>
                    </button>
                    <button class="visita" type="button">
                        <a href="../html/exercicio.php">Visite exercícios enviados por professores!</a>
                    </button>
            <?php elseif ($tipoUsuario == 'professor'): ?>
                <button class="criar" type="button">
                        <a href="../html/criarE.php">Crie um exercicio aqui!</a>
                    </button>
                    <button class="visita" type="button">
                        <a href="../html/perguntas.php">Visite perguntas enviados por alunos!</a>
                    </button>
            <?php endif; ?>
                    
            </div>
        </div>
        <div class="divisoria"></div>
        <h1 id="contato">Quem somos nós?</h1>
        <p class="p1">Nós da Clarify buscamos auxiliar vocês alunos com suas dúvidas e seus estudos!</p></p>
        <p class="p1">Sabemos como as vezes o acesso a profissionais da educação pode ser difícil e, mesmo com a internet,</br>não se pode confiar em tudo em que vê.</p>
        <p class="p1">Por isso, nós criamos o Clarify, permitindo que você possa realizar suas pesquisas com garantia nos resultados!</p>
        <p class="p1">Nosso sistema oferece maior acessibilidade a professores qualificados para tirar suas dúvidas</br>e ajudar a resolver questões, além de diversos exercícios criados por eles para você praticar.</p>
        <p class="p1">Esperamos ajudar você da melhor maneira possível e contribuir no seu aprendizado!</p>
        <p class="p2">Caso precise relatar algum problema, entre contato com a nossa empresa:</p>
        <h3 class="email">clarify@gmail.com</h3>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>