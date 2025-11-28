<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('../php/conexao.php'); 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: perguntas.php');
    exit();
}

$id_pergunta = mysqli_real_escape_string($mysqli, $_GET['id']);

// busca a pergunta
$query_pergunta = "
    SELECT 
        p.idPerguntas, p.titulo, p.descricao, p.materia, p.dataCriacao, 
        u.nome AS nome_usuario, u.ehAdmin,
        u.ehAdmin AS autor_ehAdmin,
        p.idUsuario AS id_autor_pergunta
    FROM 
        perguntas p
    JOIN 
        usuario u ON p.idUsuario = u.idUsuario
    WHERE 
        p.idPerguntas = '$id_pergunta'
";
$resultado_pergunta = mysqli_query($mysqli, $query_pergunta);
$pergunta = mysqli_fetch_assoc($resultado_pergunta);

$idUsuarioLogado = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$ehAdminLogado = isset($_SESSION['ehAdmin']) ? $_SESSION['ehAdmin'] : 0;

if ($idUsuarioLogado && !isset($_SESSION['ehAdmin'])) {
    $queryAdmin = "SELECT ehAdmin FROM usuario WHERE idUsuario = '$idUsuarioLogado'";
    $resultadoAdmin = mysqli_query($mysqli, $queryAdmin);
    if ($adminRow = mysqli_fetch_assoc($resultadoAdmin)) {
        $ehAdminLogado = $adminRow['ehAdmin'];
        $_SESSION['ehAdmin'] = $ehAdminLogado; // Opcional: Salvar na sessão
    }
}

if (!$pergunta) {
    header('Location: perguntas.php');
    exit();
}

// busca as respostas
$query_respostas = "
    SELECT 
        r.conteudo, r.dataResposta, 
        u.nome AS nome_usuario, u.ehAdmin, 
        p.especializacao AS prof_especializacao,
        (SELECT COUNT(idProfessor) FROM professor WHERE idUsuario = u.idUsuario) AS is_professor_flag 
    FROM 
        respostas r
    JOIN 
        usuario u ON r.idUsuario = u.idUsuario
    LEFT JOIN
        professor p ON u.idUsuario = p.idUsuario 
    WHERE 
        r.idPerguntas = '$id_pergunta'
    ORDER BY 
        r.dataResposta ASC
";

$resultado_respostas = mysqli_query($mysqli, $query_respostas);
$respostas = mysqli_fetch_all($resultado_respostas, MYSQLI_ASSOC);

$sucesso = null;
if (isset($_SESSION['sucesso_resposta'])) {
    $sucesso = $_SESSION['sucesso_resposta'];
    unset($_SESSION['sucesso_resposta']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../css/visualizar_pergunta.css">
    <link rel="icon" type="imagex/png" href="../images/clarifyFinal.png">
    <title>Clarify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">

    <?php include '../php/navbar.php'; ?>
    
    <div class="container" style="padding-top: 30px;">
        
        <div class="pergunta-view">
            <h1><?php echo htmlspecialchars($pergunta['titulo']); ?></h1>
            <p class="lead"><?php echo nl2br(htmlspecialchars($pergunta['descricao'])); ?></p>
            <hr>

            <?php 
            $idAutorPergunta = $pergunta['id_autor_pergunta'];
            $podeDeletar = false;
        
            if ($idUsuarioLogado) {
                $isAutor = ($idUsuarioLogado == $idAutorPergunta);
                $isAdmin = ($ehAdminLogado == 1); 
            
                $podeDeletar = $isAutor || $isAdmin;
            }

                if ($podeDeletar): 
            ?> 
            <div class="mb-3">
            <a 
                style="background-color: #B64952;"
                href="../php/deletar_pergunta.php?id=<?php echo $pergunta['idPerguntas']; ?>" 
                class="btn btn-danger btn-sm" 
                onclick="return confirm('ATENÇÃO: Tem certeza que deseja excluir esta pergunta? Esta ação é irreversível.');"
            >
                Excluir Pergunta
            </a>
            
        </div>
    <?php endif; ?>
    <small class="text-muted">

            <small class="text-muted">
                Postado por: <strong><?php echo htmlspecialchars($pergunta['nome_usuario']); ?></strong> | 
                Matéria: <span class="materia-tag"><?php echo htmlspecialchars($pergunta['materia']); ?></span> | 
                Em: <?php echo date('d/m/Y H:i', strtotime($pergunta['dataCriacao'])); ?>
            </small>
            
    </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="my-4">
                <h2>Adicionar Resposta</h2>
                
                <?php if ($sucesso): ?>
                    <div class="alert alert-success"><?php echo $sucesso; ?></div>
                <?php endif; ?>

                <form method="POST" action="../php/processar_resposta.php">
                    <input type="hidden" name="id_pergunta" value="<?php echo $pergunta['idPerguntas']; ?>"> 
                    
                    <div class="form-group mb-3">
                        <textarea name="conteudo_resposta" class="form-control" rows="5" placeholder="Digite sua resposta aqui..." required></textarea>
                    </div>
                    <button type="submit" name="enviar_resposta" class="btn" style="background-color: #B6D0E2;">Enviar Resposta</button>
                </form>
            </div>
            <hr>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Faça <a href="login.php">login</a> para responder a esta pergunta.
            </div>
        <?php endif; ?>

        <h2 class="mt-5">Respostas (<?php echo count($respostas); ?>)</h2>

        <?php if (empty($respostas)): ?>
            <p class="text-info">Seja o primeiro a responder!</p>
        <?php else: ?>
            <?php foreach ($respostas as $resposta): ?>
                
                <?php 
                    $eh_professor = ($resposta['is_professor_flag'] > 0);
                    $classe_destaque = $eh_professor ? 'resposta-professor' : ''; 
                    
                    $tag_professor = '';
                    
                    if ($eh_professor) {
                        $especializacao_texto = empty($resposta['prof_especializacao']) 
                            ? 'Não informada' 
                            : htmlspecialchars($resposta['prof_especializacao']);
                        
                        $tag_professor = '<span class="professor-tag text-success">Especialização: ' . $especializacao_texto . '</span>';
                    }
                ?>
                
                <div class="resposta-card <?php echo $classe_destaque; ?>">
                    <p><?php echo nl2br(htmlspecialchars($resposta['conteudo'])); ?></p>
                    <small class="text-muted">
                        Respondido por: 
                        <strong><?php echo htmlspecialchars($resposta['nome_usuario']); ?></strong>
                        <?php echo $tag_professor; ?>
                        | Em: <?php echo date('d/m/Y H:i', strtotime($resposta['dataResposta'])); ?>
                    </small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>