<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CarrinhoCompras";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

$sql = "SELECT codigoproduto, nome, quantidade, preco FROM produtos";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>