<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nomeProduto'];
    $quantidade = $_POST['quantidadeProduto'];
    $preco = $_POST['precoProduto'];

    // Verifica se o nome contém apenas letras e espaços
    if (!preg_match('/^[A-Za-z\s]+$/', $nome)) {
        echo 'O campo nome não pode conter números ou caracteres especiais.';
        header('Location: index.php');
        exit();
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO produtos (nome, quantidade, preco) VALUES ('$nome', $quantidade, $preco)";
    if ($conn->query($sql) === true) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erro ao inserir o produto: ' . $conn->error;
    }
} else {
    header('Location: index.php');
    exit();
}
?>