<?php 
$path = $_SERVER["DOCUMENT_ROOT"] . "/ecommerce";
include_once($path . "/models/carrinhos.php");
include_once($path . "/conexao.php");

class CarrinhosController{
    public function listaProdutos($objproduto){
        // Obtém os produtos do carrinho com seus preços
        $produtosCarrinho = $objproduto->Listar();
        
        // Calcula o valor total do carrinho
        $valorTotalCarrinho = 0;
        foreach ($produtosCarrinho as $produto) {
            $valorTotalCarrinho += $produto['Preco'] * $produto['Quantidade']; // Calculando o valor total
        }

        // Retorna os produtos e o valor total
        return [
            'produtos' => $produtosCarrinho,
            'valorTotal' => $valorTotalCarrinho
        ];
    }
    

    public function precoProduto($preco, $quantidade){
        $preco *= $quantidade;
        return $preco;
    }

    public function adicionarProduto($produtoId, $usuarioId) {
        // Cria uma conexão com o banco de dados
        $conexao = (new Conexao())->getConexao();
        // Cria um objeto Carrinho
        $carrinho = new Carrinhos();
        
        // Inicia a sessão
        session_start();

        // Seleciona o ID do Produto e Usuario
        $carrinho->setProdutoId($_SESSION["produto_id"]);
        $carrinho->setUsuarioId($_SESSION["usuario_id"]);
    
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
            echo "Não foi possivel adicionar o produto ao carrinho!";
            return false; // Ocorreu um erro
        }
    }
}
?>