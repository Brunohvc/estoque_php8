<?php
include 'db_connection.php';

function atualizarEstoque($jsonProdutos) {
    $pdo = getDatabaseConnection();

    $produtos = json_decode($jsonProdutos, true);

    try {
        $pdo->beginTransaction();

        $insertStmt = $pdo->prepare("INSERT INTO estoque (produto, cor, tamanho, deposito, data_disponibilidade, quantidade) VALUES (:produto, :cor, :tamanho, :deposito, :data_disponibilidade, :quantidade)");
        $updateStmt = $pdo->prepare("UPDATE estoque SET produto = :produto, cor = :cor, tamanho = :tamanho, deposito = :deposito, data_disponibilidade = :data_disponibilidade, quantidade = :quantidade WHERE id = :id");

        foreach ($produtos as $produto) {
            if (isset($produto['id']) && !empty($produto['id'])) {
                // Update existing item
                $updateStmt->execute([
                    ':id' => $produto['id'],
                    ':produto' => $produto['produto'],
                    ':cor' => $produto['cor'],
                    ':tamanho' => $produto['tamanho'],
                    ':deposito' => $produto['deposito'],
                    ':data_disponibilidade' => $produto['data_disponibilidade'],
                    ':quantidade' => $produto['quantidade']
                ]);
            } else {
                // Insert new item
                $insertStmt->execute([
                    ':produto' => $produto['produto'],
                    ':cor' => $produto['cor'],
                    ':tamanho' => $produto['tamanho'],
                    ':deposito' => $produto['deposito'],
                    ':data_disponibilidade' => $produto['data_disponibilidade'],
                    ':quantidade' => $produto['quantidade']
                ]);
            }
        }

        $pdo->commit();
        echo "Estoque atualizado com sucesso!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erro ao atualizar estoque: " . $e->getMessage();
    }
}

function getItemCount() {
    $pdo = getDatabaseConnection();

    try {
        $countStmt = $pdo->query("SELECT COUNT(*) AS itemCount FROM estoque");
        $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);
        echo $countResult['itemCount'];
    } catch (Exception $e) {
        echo "Erro ao obter a contagem de itens: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['jsonProdutos'])) {
        $jsonProdutos = $_POST['jsonProdutos'];
        atualizarEstoque($jsonProdutos);
    } else {
        echo "Dados de produtos não fornecidos.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    getItemCount();
}
?>
