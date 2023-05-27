<?php
require 'connection.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['descricaoLista'])) {
        $descricaoLista = $_POST['descricaoLista'];

        if (!empty($descricaoLista)) {
            // Inserir a lista na tabela lista e obter o código da lista gerado
            $sqlLista = "INSERT INTO lista (Descricao) VALUES (?)";
            $stmtLista = $conn->prepare($sqlLista);
            $stmtLista->bind_param("s", $descricaoLista);

            if ($stmtLista->execute()) {
                $codigolista = $stmtLista->insert_id;
                echo "Lista salva com sucesso!";
                exit();
            } else {
                echo "Erro ao salvar a lista: " . $stmtLista->error;
            }

            $stmtLista->close();
            $conn->close();
        } else {
            echo "Nome da Lista deve ser informado.";
        }
    } else {
        echo "Os campos obrigatórios não foram enviados.";
    }
}
?>