<?php 
$path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce'; // Caminho Principal da Página
include_once($path."/conexao.php"); // Importa a Classe de Conexão

class Pedidos {
    // Atributos da Classe
    private $id;
    private $valor;
    private $status;
    private $usuario_id;

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    // Cadastra um Pedido
    public function cadastrar() {
        session_start(); // Inicializa a Sessão
        $objconexao = new Conexao(); // Instância da Classe Conexão
        $conexao = $objconexao->getConexao(); // Conecta ao DB

        // Insere na Tabela Pedidos o Valor, o Status, o Usuario_id
        $sql = "INSERT INTO Pedidos (Valor, Status, Usuario_id) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        // Define o status e usuário_id para o pedido
        $status = 'pendente'; 
        $usuario_id = $_SESSION['usuario_id'];

        $stmt->bind_param('dii', $_SESSION["valorTotalCarrinho"], $status, $usuario_id);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Erro ao cadastrar o pedido";
            return false;
        }
    }
}
?>
