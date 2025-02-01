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
    public function cadastrar() {
        $objconexao = new Conexao(); // Instancia a Classe Conexão
        $conexao = $objconexao->getConexao(); // Cria uma Conexão com o BD

        // Insere na Tabela Carrinhos o ID, Usuario_id, Produto_id e a Quantidade
        $sql = "INSERT INTO Carrinhos (ID, Usuario_id, Produto_id, Quantidade) 
                VALUES (?, ?, ?, ?)"; // Comando SQL com placeholders

        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Associa os parâmetros
            mysqli_stmt_bind_param($stmt, 'iiii', $this->id, $this->usuario_id, $this->produto_id, $this->quantidade);

            // Executa a consulta
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conexao); // Fecha a conexão com o DB
                return "Sucesso"; // Retorna sucesso
            } else {
                mysqli_stmt_close($stmt);
                mysqli_close($conexao);
                return "Erro"; // Retorna mensagem de erro
            }
        }

        mysqli_close($conexao); // Fecha a conexão com o DB
    }

    // Método para listar os produtos do carrinho
    public function Listar() {
        $objconexao = new Conexao(); // Instancia a classe Conexão
        $conexao = $objconexao->getConexao(); // Conecta ao DB
        $arrayProdutos = [];
        $sql = "SELECT * FROM Carrinhos"; // Comando SQL para consulta
        $resposta = mysqli_query($conexao, $sql); // Consulta no DB

        while ($produtoCarrinho = mysqli_fetch_assoc($resposta)) {
            // Para cada produto, busca o preço na tabela Produtos
            $produtoId = $produtoCarrinho['Produto_id'];
            $sqlPreco = "SELECT Valor FROM Produtos WHERE ID = ?"; // Comando SQL com placeholder

            if ($stmtPreco = mysqli_prepare($conexao, $sqlPreco)) {
                // Associa os parâmetros
                mysqli_stmt_bind_param($stmtPreco, 'i', $produtoId);

                // Executa a consulta
                if (mysqli_stmt_execute($stmtPreco)) {
                    mysqli_stmt_bind_result($stmtPreco, $preco);
                    mysqli_stmt_fetch($stmtPreco);
                    $produtoCarrinho['Preco'] = $preco ?? 0; // Adiciona o preço ao produto, ou 0 se não encontrado
                    mysqli_stmt_close($stmtPreco);
                } else {
                    $produtoCarrinho['Preco'] = 0; // Se não encontrar, define como 0
                }
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
        $sql = "SELECT * FROM Carrinhos WHERE Produto_id = ? AND Usuario_id = ?";
        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Associa os parâmetros
            mysqli_stmt_bind_param($stmt, 'ii', $produtoId, $usuarioId);

            // Executa a consulta
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($resultado) > 0) {
                // Produto já existe, incrementa a quantidade
                $row = mysqli_fetch_assoc($resultado);
                $novaQuantidade = $row['Quantidade'] + 1;
                $sqlUpdate = "UPDATE Carrinhos SET Quantidade = ? WHERE Produto_id = ? AND Usuario_id = ?";

                if ($stmtUpdate = mysqli_prepare($conexao, $sqlUpdate)) {
                    // Associa os parâmetros
                    mysqli_stmt_bind_param($stmtUpdate, 'iii', $novaQuantidade, $produtoId, $usuarioId);

                    // Executa a consulta
                    if (mysqli_stmt_execute($stmtUpdate)) {
                        mysqli_stmt_close($stmtUpdate);
                        mysqli_stmt_close($stmt);
                        mysqli_close($conexao);
                        return true; // Produto atualizado com sucesso
                    } else {
                        mysqli_stmt_close($stmtUpdate);
                        mysqli_stmt_close($stmt);
                        mysqli_close($conexao);
                        return false; // Erro ao atualizar
                    }
                }
            } else {
                // Produto não existe, insere um novo registro
                $sqlInsert = "INSERT INTO Carrinhos (Usuario_id, Produto_id, Quantidade) VALUES (?, ?, ?)";

                if ($stmtInsert = mysqli_prepare($conexao, $sqlInsert)) {
                    // Associa os parâmetros
                    $quantidade = 1; // Quantidade inicial
                    mysqli_stmt_bind_param($stmtInsert, 'iii', $usuarioId, $produtoId, $quantidade);

                    // Executa a consulta
                    if (mysqli_stmt_execute($stmtInsert)) {
                        mysqli_stmt_close($stmtInsert);
                        mysqli_stmt_close($stmt);
                        mysqli_close($conexao);
                        return true; // Produto adicionado com sucesso
                    } else {
                        mysqli_stmt_close($stmtInsert);
                        mysqli_stmt_close($stmt);
                        mysqli_close($conexao);
                        return false; // Erro ao inserir
                    }
                }
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($conexao); // Fecha a conexão com o DB
    }
}
?>