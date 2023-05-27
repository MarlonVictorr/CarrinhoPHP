<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CarrinhoCompras";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {


    $sql = "SELECT `CodigoLista`, `Descricao` FROM `lista`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $row = array(); 
}
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lista de Compras</title>
    <link rel="stylesheet" href="./css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />

    <style>
    .bg-custom {
        background-color: #6d01f9;
    }
    </style>
</head>

<body>
    <header class="header bg-custom py-3">
        <h1 class="header-title text-center text-light">Lista Produtos</h1>
    </header>

    <main>
        <div class="page-title"></div>
        <div class="content">
            <section>
                <table id="tblDados" class="table table-bordered table-hover">
                    <thead class="bg-dark">
                        <tr>
                            <th class="text-white">Nome</th>
                            <th class="text-white">Produtos da lista</th>
                            <th class="text-white">Editar</th>
                            <th class="text-white">Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($row) > 0) : ?>
                        <?php foreach ($row as $rowLista) : ?>
                        <tr>
                            <td><?php echo $rowLista['Descricao']; ?></td>

                            <td>
                                <button class="btn btn-success" data-toggle="modal"
                                    data-target="#modalDetalhes<?php echo $rowLista['CodigoLista']; ?>">Detalhes</button>
                            </td>


                            <td>
                                <button type="button" class="edit" data-toggle="modal" data-target="#modalEditar"
                                    data-codigolista="<?php echo $rowLista['CodigoLista']; ?>">
                                    <i class="bx bx-edit"></i>
                                </button>
                            </td>
                            <td>
                                <button type="submit" class="remove"
                                    onclick="return confirm('Tem certeza que deseja excluir o registro?')">
                                    <i class="bx bx-x"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">Nenhum registro encontrado</td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <?php foreach ($row as $rowLista) : ?>
                <div class="modal fade" id="modalDetalhes<?php echo $rowLista['CodigoLista']; ?>" tabindex="-1"
                    role="dialog" aria-labelledby="modalDetalhesLabel<?php echo $rowLista['CodigoLista']; ?>"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="modalDetalhesLabel<?php echo $rowLista['CodigoLista']; ?>">
                                    Detalhes da Lista</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="padding-right: 1rem;">
                                <div id="detalhesLista<?php echo $rowLista['CodigoLista']; ?>">
                                    <!-- Conteúdo dos detalhes da lista será carregado aqui -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                $(document).ready(function() {
                    $('#modalDetalhes<?php echo $rowLista['CodigoLista']; ?>').on('show.bs.modal', function() {
                        var detalhesListaContainer = $(
                            '#detalhesLista<?php echo $rowLista['CodigoLista']; ?>');
                        detalhesListaContainer.load(
                            'detalhesLista.php?idLista=<?php echo $rowLista['CodigoLista']; ?>'
                        );
                    });
                });
                </script>

        </div>

        <?php endforeach; ?>

        <script>
        $(document).ready(function() {
            $('.edit').click(function() {
                var codigolista = $(this).data('codigolista');
                var nomeLista = $(this).closest('tr').find('.nomeLista').text();

                $('#inputCodigoLista').val(codigolista);
                $('#nomeLista').val(nomeLista);
            });
        });
        </script>

        </section>
        </div>
    </main>

    <div id="modalAdicionarProduto" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modalAdicionarProdutoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarProdutoLabel">Adicionar Produto</h5>
                    <button type="button" class="close btn-no-focus" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formAddProduto" action="modalItemLista.php" method="POST">
                        <div class="form-group">
                            <label for="descricaoLista">Nome da Lista:</label>
                            <select class="form-control" id="descricaoLista" name="descricaoLista" required>
                                <?php
                                $sqlLista = "SELECT CodigoLista, Descricao FROM lista";
                                $resultLista = $conn->query($sqlLista);
                                if ($resultLista->num_rows > 0) {
                                    while ($rowLista = $resultLista->fetch_assoc()) {
                                        echo "<option value='" . $rowLista['CodigoLista'] . "'>" . $rowLista['Descricao'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomeProduto">Nome do Produto:</label>
                            <select class="form-control" id="nomeProduto" name="nomeProduto" required>
                                <?php
                                $sqlProduto = "SELECT CodigoProduto, Nome FROM produtos";
                                $resultProduto = $conn->query($sqlProduto);
                                if ($resultProduto->num_rows > 0) {
                                    while ($rowProduto = $resultProduto->fetch_assoc()) {
                                        echo "<option value='" . $rowProduto['CodigoProduto'] . "'>" . $rowProduto['Nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantidadeProduto">Quantidade:</label>
                            <input type="number" class="form-control" id="quantidadeProduto" name="quantidadeProduto"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="precoProduto">Preço:</label>
                            <input type="number" class="form-control" id="precoProduto" name="precoProduto" step="0.01"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary"
                            data-target="#modalAdicionarProduto">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Lista</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarLista" action="atualizarLista.php" method="POST">
                        <input type="hidden" name="codigolista" id="inputCodigoLista" value="" />
                        <div class="form-group">
                            <label for="nomeLista">Nome da Lista:</label>
                            <input type="text" class="form-control" id="nomeLista" name="nomeLista" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#modalAdicionarProduto').on('show.bs.modal', function() {
            $('#formAddProduto')[0].reset();
        });
    });
    </script>

</body>

</html>