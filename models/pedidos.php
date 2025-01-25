<?php 
$path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce';
include_once($path."/conexao.php");

class Pedidos {
    private $id;
    private $valor;
    private $status;
    private $usuario_id;

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

    public function cadastrar() {
        session_start();
        $objconexao = new Conexao();
        $conexao = $objconexao->getConexao();

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
