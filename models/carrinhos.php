<?php 
// Define o caminho para a raiz do servidor e concatena com o diretório 'ecommerce'
$path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce';
    
// Inclui o arquivo de conexão com o banco de dados
include_once($path."/conexao.php");

// Define a classe Carrinhos
class Carrinhos {
    private $id;
    private $usuario_id;
    private $produto_id;
    private $quantidade;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getUsuarioId(){
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id){
        $this->usuario_id = $usuario_id;
    }

    public function getProdutoId(){
        return $this->produto_id;
    }

    public function setProdutoId($produto_id){
        $this->produto_id = $produto_id;
    }

    public function getQuantidade(){
        return $this->quantidade;
    }

    public function setQuantidade($quantidade){
        $this->quantidade = $quantidade;
    }

    // Função para cadastrar um produto
    public function cadastrar(){
        $objconexao = new Conexao(); // Instancia a Classe Conexão
        $conexao = $objconexao->getConexao(); // Cria uma Conexão com o BD

        $sql = "INSERT INTO Carrinhos (ID,Usuario_id,Produto_id,Quantidade) 
                VALUES('$this->id', '$this->usuario_id', '$this->produto_id', '$this->quantidade')"; // Comando SQL

        // Se ocorrer tudo bem
        if(mysqli_query($conexao, $sql)){
            return "Sucesso"; // Retorna sucesso
        } else{
            return "Erro"; // Retorna mensagem de erro
        }
        mysqli_close($conexao); // Fecha a conexão com o DB
    }

    public function Listar(){
        $objconexao = new Conexao(); // Instancia a classe Conexao
        $conexao = $objconexao->getConexao(); // Conecta ao DB
        $arrayCarrinho = [];
        $sql = "SELECT * FROM Carrinhos"; // Comando SQL para Consulta

        $resposta = mysqli_query($conexao, $sql); // Consulta no DB
        while($produto = mysqli_fetch_assoc($resposta)){
            array_push($arrayCarrinho, $produto);
        }

        mysqli_close($conexao);
        return $arrayCarrinho;
    }
}
?>