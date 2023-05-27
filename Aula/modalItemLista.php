<?php
require 'connection.php'
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['descricaoLista'], $_POST['nomeProduto'], $_POST['quantidadeProduto'], $_POST['precoProduto'])) {
        $descricaoLista = $_POST['descricaoLista'];
        $nomeProduto = $_POST['nomeProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $precoProduto = $_POST['precoProduto'];

     
        if (!empty($descricaoLista) && !empty($nomeProduto)) {
            

            $sql = "INSERT INTO itemlista (CodigoLista, CodigoProduto) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $descricaoLista, $nomeProduto);

            if ($stmt->execute()) {
                echo "Produto adicionado com sucesso!";
                header('Location: listaProdutos.php');
        exit();
            } else {
                echo "Erro ao adicionar o produto: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Nome da Lista e Nome do Produto devem ser selecionados.";
        }
    } else {
        echo "Os campos obrigatórios não foram enviados.";
    }
}

?>