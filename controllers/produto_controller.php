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
                return;
            }

            // Verifica se o valor é inválido (ele deve ser um número e não nulo)
            if ($objproduto->getValor() == NULL || !is_numeric($objproduto->getValor())) {
                echo "Valor Inválido";
                return;
            }

            // Verifica se a categoria é inválida
            if($objproduto->getCategoria() == NULL || strlen($objproduto->getCategoria()) > 100){
                echo "Categoria Inválida";
                return;
            }

            // Verifica se a quantidade é inválida (ele deve ser um número e não nulo)
            if ($objproduto->getQuantidade() == NULL || !is_numeric($objproduto->getQuantidade())) {
                echo "Quantidade Inválida";
                return;
            }

            // Se o upload da imagem não for bem-sucedido, retorna um erro
            if(!isset($_FILES["imagem"]) || !$this->uploadImagem($_FILES["imagem"])){
                echo "A Imagem não foi carregada";
                return;
            }

            // Se não houver erros, cadastra o produto e retorna sucesso
            $objproduto->cadastrar();
            return "Produto cadastrado com sucesso!";
        }

        public function listaProdutos($objproduto){
            // Verifique se a quantidade do produto é 0 (indicação de estoque vazio)
            if($objproduto->getQuantidade() == 0){
                echo "Acabou o Estoque";
            } else {
                return $objproduto->Listar();
            }
        } 

        // Função para fazer o upload da imagem
        public function uploadImagem($objimagem){
            // Caminho do Arquivo
            $path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce";
            
            // Diretório onde a imagem será salva
            $target_dir = $path . DIRECTORY_SEPARATOR  . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "produtos" . DIRECTORY_SEPARATOR;
            
            // Verifica se o diretório existe, caso contrário, cria
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); // Cria o diretório e garante que ele tem permissão correta
            }

            // Caminho completo do arquivo (diretório + nome do arquivo)
            $target_file = $target_dir . basename($objimagem["name"]);
            
            // Obtém a extensão do arquivo da imagem
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            // Verifica se o arquivo é uma imagem
            $check = getimagesize($objimagem["tmp_name"]);
            if($check === false){
                echo "O arquivo não é uma imagem válida.";
                return false;
            }

            // Verifica se o arquivo já existe
            if(file_exists($target_file)){
                echo "A imagem já existe.";
                return false;
            }

            // Verifica o tamanho do arquivo
            if($objimagem["size"] > 1000000){
                echo "A Imagem deve ter até 1Mb.";
                return false;
            }

            // Verifica a extensão do arquivo
            if($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType != "jpeg"){
                echo "Apenas imagens com extensão jpg, png ou jpeg são permitidas.";
                return false;
            }

            // Tenta mover o arquivo carregado para o diretório de destino
            if(move_uploaded_file($objimagem["tmp_name"], $target_file)){
                return true;
            } else {
                echo "Ocorreu um erro ao enviar a imagem.";
                return false;
            }
        }
    }
?>
