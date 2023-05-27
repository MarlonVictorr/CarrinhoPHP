<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoproduto = $_POST['codigoproduto'];
    $nome = $_POST['nomeProduto'];
    $quantidade = $_POST['quantidadeProduto'];
    $preco = $_POST['precoProduto'];

    $sql = "UPDATE produtos SET nome = '$nome', quantidade = $quantidade, preco = $preco WHERE codigoproduto = $codigoproduto";
    if ($conn->query($sql) === true) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erro ao atualizar o produto: ' . $conn->error;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['codigoproduto'])) {
    $codigoproduto = $_GET['codigoproduto'];


    $sql = "SELECT * FROM produtos WHERE codigoproduto = $codigoproduto";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $quantidade = $row['quantidade'];
        $preco = $row['preco'];
    } else {
        echo 'Produto não encontrado.';
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>