<?php

include ('../php/conexao.php'); 
session_start();

//tenho q fazer o bglh se nao aceitar admin mas o login do admin nn ta pronto

// consulta o bd pra ver os professores pendentes
$query = "
    SELECT 
        u.idUsuario, 
        u.nome, 
        u.email,
        cp.idProfessor,
        cp.especializacao,
        cp.caminhoDocumento
    FROM 
        usuario u
    JOIN 
        professor cp ON u.idUsuario = cp.idUsuario
    WHERE 
        cp.statusConfirmacao = 'pendente'
";

$resultado = mysqli_query($mysqli, $query) or die('Erro ao buscar professores pendentes: ' . mysqli_error($mysqli));

$professores_pendentes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #8AB3D0;">
    <nav class="navbar">
        <img src="../images/clarifyv1.png" alt="logo">
        <div class="navbar-links">
        </div>
        <div class="entrar">
            <a href="../html/login.php" style="text-decoration: none;"><button class="login" >Login</button></a>
            <a href="../html/cadastro.php" style="text-decoration: none;"><button class="cadastro" >Cadastro</button></a>
        </div>
    </nav>
    <nav class="navbar2">
        <div class="navbar-links2">
            <ul>
                <li class="right"><a href="#scroll1">Inicio</a></li>
                <div class="barra"></div>
                <li><a href="/html/criar.php">Perguntas</a></li>
                <div class="barra"></div>
                <li><a href="/html/perguntas.html">Atividades</a></li>
                <div class="barra"></div>
                <li><a href="#scroll2">Contato</a></li>
                <div class="barra"></div>
                <li><a href="../html/perfil.php">Perfil</a></li>
            </ul>
        </div>
        <div class="form">
            <input type="email" class="pesquisa" placeholder="🔍 PESQUISAR">
        </div>
    </nav>
    <h1>Painel de Administração</h1>
    <p>Bem-vindo, Administrador. <a href="../php/logout.php">Sair</a></p>
    
    <h2>Professores Aguardando Confirmação</h2>

    <?php if (empty($professores_pendentes)): ?>
        <p>🎉 Não há professores aguardando confirmação no momento.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Especialização</th>
                    <th>Documento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professores_pendentes as $professor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($professor['idProfessor']); ?></td>
                        <td><?php echo htmlspecialchars($professor['nome']); ?></td>
                        <td><?php echo htmlspecialchars($professor['email']); ?></td>
                        <td><?php echo htmlspecialchars($professor['especializacao']); ?></td>
                        <td>
                            <?php 
                            $caminho_doc = htmlspecialchars($professor['caminhoDocumento']);
                            if ($caminho_doc): 
                                // O link deve ser para o arquivo no servidor
                                $link_documento = str_replace('../upload;documentoprofs', '/', $caminho_doc); 
                            ?>
                                <a href="<?php echo $link_documento; ?>" target="_blank" class="btn-ver">Ver Documento</a>
                            <?php else: ?>
                                Não enviado
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="../php/aprovar_professor.php" method="POST" style="display:inline;">
                                <input type="hidden" name="idProfessor" value="<?php echo $professor['idProfessor']; ?>">
                                <button type="submit" name="acao" value="aprovar" class="btn-aprovar">Aprovar</button>
                            </form>
                            <form action="../php/aprovar_professor.php" method="POST" style="display:inline;">
                                <input type="hidden" name="idProfessor" value="<?php echo $professor['idProfessor']; ?>">
                                <button type="submit" name="acao" value="rejeitar" style="background-color: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 3px;">Rejeitar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>