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

     // Método para listar os produtos do carrinho
     public function Listar() {
        $objconexao = new Conexao(); // Instancia a classe Conexao
        $conexao = $objconexao->getConexao(); // Conecta ao DB
        $arrayProdutos = [];
        $sql = "SELECT * FROM Carrinhos"; // Comando SQL para consulta
        $resposta = mysqli_query($conexao, $sql); // Consulta no DB
        
        while($produtoCarrinho = mysqli_fetch_assoc($resposta)){
            // Para cada produto, busca o preço na tabela Produtos
            $produtoId = $produtoCarrinho['Produto_id'];
            $sqlPreco = "SELECT Valor FROM Produtos WHERE ID = '$produtoId'";
            $respostaPreco = mysqli_query($conexao, $sqlPreco);
            if ($respostaPreco && mysqli_num_rows($respostaPreco) > 0) {
                $produto = mysqli_fetch_assoc($respostaPreco);
                $produtoCarrinho['Preco'] = $produto['Valor']; // Adiciona o preço ao produto
            } else {
                $produtoCarrinho['Preco'] = 0; // Se não encontrar, define como 0
            }

            array_push($arrayProdutos, $produtoCarrinho); // Adiciona o produto ao carrinho
        }

        mysqli_close($conexao); // Fecha a conexão
        return $arrayProdutos; // Retorna os produtos com preço
    }

    // Método para verificar se o produto já existe e adicionar ou atualizar
    public function adicionarOuAtualizarProduto($usuarioId, $produtoId) {
        $objconexao = new Conexao(); // Instancia a Classe Conexão
        $conexao = $objconexao->getConexao(); // Cria uma Conexão com o BD

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
        mysqli_close($conexao); // Fecha a conexão com o DB
    }
}
?>