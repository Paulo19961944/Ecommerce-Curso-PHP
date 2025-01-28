<?php 
    $path = $_SERVER["DOCUMENT_ROOT"] . "/ecommerce"; // Define o Caminho Principal
    include_once($path . "/conexao.php");

    class ProdutosPedidos {
        private $id;
        private $produto_id;
        private $pedido_id;
        private $valor;

        // Define os Getters e Setters
        public function getId() {
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getProdutoId(){
            return $this->produto_id;
        }

        public function setProdutoId($produto_id){
            $this->produto_id = $produto_id;
        }

        public function getPedidoId(){
            return $this->pedido_id;
        }

        public function setPedidoId($pedido_id){
            $this->pedido_id = $pedido_id;
        }

        public function getValor(){
            return $this->valor;
        }

        public function setValor($valor){
            $this->valor = $valor;
        }

        public function cadastrar($produto_id, $pedido_id){
            $objconexao = new Conexao(); // Importa o Objeto Conexão
            $conexao = $objconexao->getConexao(); // Conecta ao DB

            $sql = "INSERT INTO Produtos_Pedidos(ID, Produto_id, Pedidos_id, Valor) VALUES (?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param('dii', $this->id, $_SESSION["produtoId"], $_SESSION["pedidoId"], $_SESSION["valorTotalCarrinho"]);

            if($stmt->execute()){
                return true;
            } else{
                return false;
                echo "Erro ao cadastrar o Produto e o Pedido";
            }
        }

    }
?>