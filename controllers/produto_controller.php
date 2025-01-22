<?php 
    // Caminho da Raiz do Documento
    $path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce"; 
    
    // Importa o Model Produto
    include_once($path . '/models/produto.php'); 

    class ProdutoController{
        
        // Função para obter o caminho da imagem baseado na ID
        public function getImagemById($id) {
            // Caminho absoluto do documento
            $path = $_SERVER["DOCUMENT_ROOT"] . "/ecommerce"; 
            // Carrega o arquivo JSON com os caminhos das imagens
            $jsonFile = file_get_contents($path . '/public/json/imagens.json');
            // Decodifica o JSON
            $imagens = json_decode($jsonFile, true);
        
            // Verifica se existe uma imagem para o id fornecido
            foreach ($imagens as $imagem) {
                if ($imagem['id'] == $id) {
                    // Aqui, vamos adicionar o prefixo http://localhost/ecommerce antes do caminho da imagem
                    return "http://localhost/ecommerce" . $imagem['image-path']; 
                }
            }
            return null; // Se não encontrar a imagem
        }        
        
        // Função para listar os produtos, agora incluindo a imagem
        public function listaProdutos($objproduto){
            // Obtém os produtos
            $produtos = $objproduto->Listar();
            
            // Associa o caminho da imagem ao produto
            foreach ($produtos as $key => $produto) {
                // Agora associamos corretamente o caminho da imagem ao produto
                $produtos[$key]['imagem'] = $this->getImagemById($produto['ID']);
            }
            
            // Retorna a lista de produtos com a imagem
            return $produtos;
        } 

        // Função para fazer o upload da imagem (não alterada)
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
