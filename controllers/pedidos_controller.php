<?php 
$path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce";
include_once($path . '/models/pedidos.php');

class PedidosController {
    public function AdicionarPedido() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /ecommerce/views/login.php");
            exit();
        }

        $objpedido = new Pedidos();

        if ($objpedido->cadastrar()) {
            header("Location: http://localhost/ecommerce/views/pedidos/lista_pedidos.php");
        }
    }
}
?>
