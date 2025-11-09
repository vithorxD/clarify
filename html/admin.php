<?php

include ('../php/conexao.php'); 
session_start();

//ve se é admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit();
}

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
    <h1>Painel de Administração</h1>
    <?php
        // mensagem pra ver se deu certo
        if (isset($_SESSION['admin_message'])):
    ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px;">
        <?php echo $_SESSION['admin_message']; ?>
    </div>
<?php
    unset($_SESSION['admin_message']); // Limpa a mensagem após exibir
endif;
?>
    <p>Bem-vindo, Administrador.</p>
    
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
                                    $base_path_to_remove = '/xampp/htdocs/clarify/'; 
                                    $link_documento = str_replace($base_path_to_remove, 'http://localhost/', $caminho_doc); 
                                ?>
                        <a href="<?php echo $link_documento; ?>" target="_blank" class="btn-ver">Ver Documento</a>
                        <?php else: ?>
                            Não enviado
                        <?php endif; ?>
                        </td>
                            <form action="../php/aprovar_prof.php" method="POST" style="display:inline;">
                                <input type="hidden" name="idProfessor" value="<?php echo $professor['idProfessor']; ?>">
                                <button type="submit" name="acao" value="aprovar" class="btn-aprovar">Aprovar</button>
                            </form>
                            <form action="../php/aprovar_prof.php" method="POST" style="display:inline;">
                                <input type="hidden" name="idProfessor" value="<?php echo $professor['idProfessor']; ?>">
                                <button type="submit" name="acao" value="rejeitar" style="background-color: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 3px;">Rejeitar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="../php/logout.php">Sair</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>