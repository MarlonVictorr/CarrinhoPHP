<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigolista = $_POST['codigolista'];
    $nomeLista = $_POST['nomeLista'];

    $sql = "UPDATE lista SET Descricao = '$nomeLista' WHERE CodigoLista = $codigolista";

    if ($conn->query($sql) === true) {
       
        header("Location: listaProdutos.php");
        exit();
    } else {
        echo "Erro ao atualizar a lista: " . $conn->error;
    }

    $conn->close();
}
?>