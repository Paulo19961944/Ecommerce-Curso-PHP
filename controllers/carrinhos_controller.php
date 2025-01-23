<?php 
$path = $_SERVER["DOCUMENT_ROOT"] . "/ecommerce";
include_once($path . "models/carrinhos.php");
include_once($path . "conexao.php");

class CarrinhosController{
    public function listaProdutos($objproduto){
        $produtos = $objproduto->Listar();
        return $produtos;
    }

    public function adicionarProduto($produtoId, $usuarioId) {
        // Cria uma conexão com o banco de dados
        $conexao = (new Conexao())->getConexao();
        // Cria um objeto Carrinho
        $carrinho = new Carrinhos();
        $carrinho->setProdutoId($produtoId);
        $carrinho->setUsuarioId($usuarioId);
    
        // Verifica se o produto já existe no carrinho
        $sql = "SELECT * FROM Carrinhos WHERE Produto_id = '$produtoId' AND Usuario_id = '$usuarioId'";
        $resultado = mysqli_query($conexao, $sql);
    
        if (mysqli_num_rows($resultado) > 0) {
            // Produto já existe, incrementa a quantidade
            $row = mysqli_fetch_assoc($resultado);
            $novaQuantidade = $row['Quantidade'] + 1;
            $sql = "UPDATE Carrinhos SET Quantidade = '$novaQuantidade' WHERE Produto_id = '$produtoId' AND Usuario_id = '$usuarioId'";
        } else {
            // Produto não existe, insere um novo registro
            $sql = "INSERT INTO Carrinhos (Usuario_id, Produto_id, Quantidade) VALUES ('$usuarioId', '$produtoId', '1')";
        }
    
        if (mysqli_query($conexao, $sql)) {
            return true; // Produto adicionado com sucesso
        } else {
            return false; // Ocorreu um erro
        }
    }
}
?>