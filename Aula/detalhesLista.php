<?php
require 'connection.php';

if (isset($_GET['idLista'])) {
    $idLista = $_GET['idLista'];

    $sql = "SELECT l.CodigoLista, p.CodigoProduto, p.Nome AS NomeProduto
    FROM itemLista il
    JOIN lista l ON il.CodigoLista = l.CodigoLista
    JOIN produtos p ON il.CodigoProduto = p.CodigoProduto
    WHERE l.CodigoLista = $idLista";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($rowProduto = $result->fetch_assoc()) {
            $nomeProduto = $rowProduto['NomeProduto'];
            echo "<ul>$nomeProduto</ul>"; // Exibe os produtos
        }
        echo "</ul>";
    } else {
        echo "Nenhum registro encontrado para a lista informada.";
    }
} else {
    echo "Essa lista não possui produtos";
}

$conn->close();
?>