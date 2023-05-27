<?php
require 'connection.php';

$codigoproduto = $_POST['codigoproduto'];


$sqlVerifica = "SELECT * FROM produtos WHERE codigoproduto = $codigoproduto";
$resultVerifica = $conn->query($sqlVerifica);

if ($resultVerifica->num_rows > 0) {
  
    $sqlDeleteProduto = "DELETE FROM produtos WHERE codigoproduto = $codigoproduto";
    
    
    if ($conn->query($sqlDeleteProduto) === true) {
        $sqlDeleteItemLista = "DELETE FROM itemlista WHERE CodigoProduto = $codigoproduto";
        
      
        if ($conn->query($sqlDeleteItemLista) === true) {
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao excluir os registros relacionados da tabela itemlista: " . $conn->error;
        }
    } else {
        echo "Erro ao excluir o registro da tabela produtos: " . $conn->error;
    }
} else {
    echo "O registro não existe na tabela produtos.";
}

$conn->close();
?>