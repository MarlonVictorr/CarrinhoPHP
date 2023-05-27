<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idLista'])) {
        $idLista = $_POST['idLista'];

        $sqlDeleteLista = "DELETE FROM lista WHERE id = $idLista";
        $sqlDeleteItensLista = "DELETE FROM itemlista WHERE CodigoLista = $idLista";

        if ($conn->query($sqlDeleteLista) === true && $conn->query($sqlDeleteItensLista) === true) {
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao excluir a lista: " . $conn->error;
        }
    }
}

$conn->close();
?>