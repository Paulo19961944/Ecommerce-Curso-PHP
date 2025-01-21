<?php 
    // Caminho da Raiz do Documento
    $path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce"; 
    
    // Importa o Model Produto
    include_once($path . '/models/produto.php'); 

    class ProdutoController{
        // Função para cadastrar um novo produto
        public function cadastraProduto($objproduto){
            
            // Define a descrição do produto com base no input do formulário
            $objproduto->setDescricao($_POST["descricao"]);
            
            // Define o valor do produto com base no input do formulário
            $objproduto->setValor($_POST["valor"]);
            
            // Define a categoria do produto com base no input do formulário
            $objproduto->setCategoria($_POST["categoria"]);
            
            // Define a quantidade do produto com base no input do formulário
            $objproduto->setQuantidade($_POST["quantidade"]);

            // Verifica se a descrição é inválida
            if($objproduto->getDescricao() == NULL || strlen($objproduto->getDescricao()) > 100){
                echo "Descrição Inválida";
            }

            // Verifica se o valor é inválido (ele deve ser um número e não nulo)
            if ($objproduto->getValor() == NULL || !is_numeric($objproduto->getValor())) {
                echo "Valor Inválido";
            }

            // Verifica se a categoria é inválida
            if($objproduto->getCategoria() == NULL || strlen($objproduto->getCategoria()) > 100){
                echo "Categoria Inválida";
            }

            // Verifica se a quantidade é inválida (ele deve ser um número e não nulo)
            if ($objproduto->getQuantidade() == NULL || !is_numeric($objproduto->getQuantidade())) {
                echo "Quantidade Inválida";
            }

            // Se não houver erros, cadastra o produto e retorna sucesso
            else{
                $objproduto->cadastrar();
                return "Sucesso";
            }
        }
    }
?>
