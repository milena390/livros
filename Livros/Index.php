<?php
// index.php
require_once 'classes/Livro.php';
require_once 'classes/LivroRepository.php';

$livroRepository = new LivroRepository();

// Adicionar livro
if (isset($_POST['adicionar'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];
    $isbn = $_POST['isbn'];

    $livro = new Livro($titulo, $autor, $ano, $isbn);
    $livroRepository->adicionar($livro);
}

// Editar livro
if (isset($_POST['editar'])) {
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    $livro = new Livro($titulo, $autor, $ano, $isbn);
    $livroRepository->editar($isbn, $livro);
}

// Excluir livro
if (isset($_POST['excluir'])) {
    $isbn = $_POST['isbn'];
    $livroRepository->excluir($isbn);
}

// Listar livros
$livros = $livroRepository->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livros</title>
</head>
<body>
    <h1>Cadastro de Livros</h1>
    <form action="index.php" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required><br>

        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor" required><br>

        <label for="ano">Ano:</label>
        <input type="number" name="ano" id="ano" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" id="isbn" required><br>

        <button type="submit" name="adicionar">Adicionar Livro</button>
    </form>

    <h2>Lista de Livros</h2>
    <ul>
        <?php foreach ($livros as $livro): ?>
            <li>
                <?= htmlspecialchars($livro['titulo']) ?> - 
                <?= htmlspecialchars($livro['autor']) ?> (<?= $livro['ano'] ?>) 
                - ISBN: <?= $livro['isbn'] ?>

                <!-- Formulário para Editar -->
                <form action="index.php" method="POST" style="display:inline;">
                    <input type="hidden" name="isbn" value="<?= $livro['isbn'] ?>">
                    <input type="text" name="titulo" value="<?= $livro['titulo'] ?>" required>
                    <input type="text" name="autor" value="<?= $livro['autor'] ?>" required>
                    <input type="number" name="ano" value="<?= $livro['ano'] ?>" required>
                    <button type="submit" name="editar">Editar</button>
                </form>

                <!-- Formulário para Excluir -->
                <form action="index.php" method="POST" style="display:inline;">
                    <input type="hidden" name="isbn" value="<?= $livro['isbn'] ?>">
                    <button type="submit" name="excluir" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
