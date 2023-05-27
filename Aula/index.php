<?php
require 'connection.php';
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
    <script src="./js/buscarDados.js"></script>

    <style>
    .bg-custom {
        background-color: #6d01f9;
    }
    </style>
</head>

<body>
    <header class="header bg-custom py-3">
        <h1 class="header-title text-center text-light">Produtos</h1>
    </header>

    <main>
        <div class="page-title"></div>
        <div class="content">
            <section>
                <table id="tblDados" class="table table-bordered table-hover">
                    <thead class="bg-dark">
                        <tr>
                            <th class="text-white">Nome</th>
                            <th class="text-white">Quantidade</th>
                            <th class="text-white">Preço</th>
                            <th class="text-white">Editar</th>
                            <th class="text-white">Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($rows) && is_array($rows) && count($rows) > 0) : ?>
                        <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= $row['nome'] ?></td>
                            <td><?= $row['quantidade'] ?></td>
                            <td><?= $row['preco'] ?></td>
                            <td>
                                <button type="button" class="edit" data-toggle="modal" data-target="#modalEditar"
                                    data-codigoproduto="<?= $row['codigoproduto'] ?>">
                                    <i class="bx bx-edit"></i>
                                </button>
                            </td>
                            <td>
                                <form id="formDelete" action="deleteProdutos.php" method="POST">
                                    <input type="hidden" name="_METHOD" value="DELETE" />
                                    <input type="hidden" name="codigoproduto" value="<?= $row['codigoproduto'] ?>" />
                                    <button type="submit" class="remove"
                                        onclick="return confirm('Tem certeza que deseja excluir o registro?')">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Nenhum registro encontrado</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Modal Editar Produtos -->
                <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditarLabel">Editar Produto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditarProduto" action="atualizarProdutos.php" method="POST">
                                    <input type="hidden" name="codigoproduto" id="inputCodigoProduto" value="" />
                                    <div class="form-group">
                                        <label for="nomeProduto">Nome:</label>
                                        <input type="text" class="form-control" id="nomeProduto" name="nomeProduto"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantidadeProduto">Quantidade:</label>
                                        <input type="number" class="form-control" id="quantidadeProduto"
                                            name="quantidadeProduto" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="precoProduto">Preço:</label>
                                        <input type="number" class="form-control" id="precoProduto" name="precoProduto"
                                            step="0.01" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Atualizar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                $(document).ready(function() {
                    $('#modalEditar').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget);
                        var codigoproduto = button.data('codigoproduto');
                        var modal = $(this);
                        modal.find('#inputCodigoProduto').val(codigoproduto);
                        modal.find('#formEditarProduto')[0].reset();
                    });
                });
                </script>
            </section>

            <aside>
                <div class="box">
                    <header>Resumo da compra</header>
                    <footer>
                        <?php
                        $sql = "SELECT SUM(preco) AS total FROM produtos";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total = $row['total'];
                        } else {
                            $total = 0;
                        }
                        ?>
                        <span id="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></span>
                    </footer>
                </div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdicionarProduto">
                    Adicionar Produto
                </button>
                <div>
                    <h1></h1>
                </div>
                <button type="button" class="btn btn-primary" onclick="window.location.href = 'listaProdutos.php'">
                    Ir para Lista De Compras
                </button>
                <div>
                    <h1></h1>
                </div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal">
                    Finalizar Compra
                </button>
            </aside>
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
                    <form id="formAddProduto" action="createProdutos.php" method="POST">
                        <div class="form-group">
                            <label for="nomeProduto">Nome:</label>
                            <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" required>
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
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nomeLista">
                        Insira um nome para a lista
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="descricaoLista" class="form-control" placeholder="Nome da Lista" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="salvarLista()">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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

    function salvarLista() {
        var descricao = $("#descricaoLista").val();

        $.ajax({
            url: "salvar_lista.php",
            method: "POST",
            data: {
                descricaoLista: descricao
            },
            success: function(response) {
                alert(response);
                $("#modal").modal("hide");
            },
            error: function() {
                alert("Erro ao processar a requisição.");
            }
        });
    }
    </script>

</body>

</html>