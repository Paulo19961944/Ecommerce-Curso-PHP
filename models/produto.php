<?php 
    // Define o caminho para a raiz do servidor e concatena com o diretório 'ecommerce'
    $path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce';
    
    // Inclui o arquivo de conexão com o banco de dados
    include_once($path."/conexao.php");

    // Define a classe Produto
    class Produto{
        // Declaração das variáveis privadas para armazenar os atributos do produto
        private $id;
        private $descricao;
        private $valor;
        private $categoria;
        private $quantidade;
        private $imagem; // Adicionando o atributo imagem

        // Método para obter o id do produto
        public function getId(){
            return $this->id;
        }

        // Método para definir o id do produto
        public function setId($id){
            $this->id = $id;
        }

        // Método para obter a descrição do produto
        public function getDescricao(){
            return $this->descricao;
        }

        // Método para definir a descrição do produto
        public function setDescricao($descricao){
            $this->descricao = $descricao;
        }

        // Método para obter o valor do produto
        public function getValor(){
            return $this->valor;
        }

        // Método para definir o valor do produto
        public function setValor($valor){
            $this->valor = $valor;
        }

        // Método para obter a categoria do produto
        public function getCategoria(){
            return $this->categoria;
        }

        // Método para definir a categoria do produto
        public function setCategoria($categoria){
            $this->categoria = $categoria;            
        }

        // Método para obter a quantidade do produto
        public function getQuantidade(){
            return $this->quantidade;
        }

        // Método para definir a quantidade do produto
        public function setQuantidade($quantidade){
            $this->quantidade = $quantidade;
        }

        // Método para obter o caminho da imagem do produto
        public function getImagem(){
            return $this->imagem;
        }

        // Método para definir o caminho da imagem do produto
        public function setImagem($imagem){
            $this->imagem = $imagem;
        }

        // Método para listar os produtos
        public function Listar(){
            $objconexao = new Conexao(); // Instancia a classe Conexao
            $conexao = $objconexao->getConexao(); // Conecta ao DB
            $arrayProdutos = [];
            $sql = "SELECT * FROM Produtos"; // Comando SQL para Consulta
    
            $resposta = mysqli_query($conexao, $sql); // Consulta no DB
            while($produto = mysqli_fetch_assoc($resposta)){
                array_push($arrayProdutos, $produto);
            }

            mysqli_close($conexao);
            return $arrayProdutos;
        }

        // Função para cadastrar um produto
        public function cadastrar(){
            $objconexao = new Conexao(); // Instancia a Classe Conexão
            $conexao = $objconexao->getConexao(); // Cria uma Conexão com o BD

            $sql = "INSERT INTO Produtos (Descricao,Valor,Categoria,Quantidade) 
                    VALUES('$this->descricao', '$this->valor', '$this->categoria', '$this->quantidade')"; // Comando SQL

            // Se ocorrer tudo bem
            if(mysqli_query($conexao, $sql)){
                return "Sucesso"; // Retorna sucesso
            } else{
                return "Erro"; // Retorna mensagem de erro
            }
            mysqli_close($conexao); // Fecha a conexão com o DB
        }

    }
?>
