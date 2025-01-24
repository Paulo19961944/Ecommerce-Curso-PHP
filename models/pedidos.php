<?php 
// Define o caminho para a raiz do servidor e concatena com o diretório 'ecommerce'
$path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce';
    
// Inclui o arquivo de conexão com o banco de dados
include_once($path."/conexao.php");

class Pedidos{
    private $id;
    private $valor;
    private $status;
    private $usuario_id;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setValor($valor){
        $this->valor = $valor;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getUsuarioId(){
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id){
        $this->usuario_id = $usuario_id;
    }
}
?>
