<?php 
$path = $_SERVER["DOCUMENT_ROOT"] . "/ecommerce";
include_once($path . "/models/carrinhos.php");
include_once($path . "/conexao.php");

class CarrinhosController {
    public function listaProdutos($objproduto) {
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
    
    public function precoProduto($preco, $quantidade) {
        $preco *= $quantidade;
        return $preco;
    }

    public function adicionarProduto($produtoId, $usuarioId) {
        // Cria uma instância do model Carrinhos
        $carrinho = new Carrinhos();

        // Tenta adicionar ou atualizar o produto no carrinho
        if ($carrinho->adicionarOuAtualizarProduto($usuarioId, $produtoId)) {
            return true; // Produto adicionado com sucesso
        } else {
            echo "Não foi possível adicionar o produto ao carrinho!";
            return false; // Ocorreu um erro
        }
    }
}
?>