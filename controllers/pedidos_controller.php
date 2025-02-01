<?php 
$path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce"; // Define o Caminho Principal
include_once($path . '/models/pedidos.php'); // Importa a Classe Pedidos

class PedidosController {
    // Adiciona um Pedido
    public function AdicionarPedido() {
        session_start(); // Inicializa a Sessão

        // Se não foi definido o usuario_id, então retornar para a página de login
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /ecommerce/views/login.php");
            exit();
        }

        // Instância da Classe Pedidos
        $objpedido = new Pedidos(); 

        // Se o Pedido foi cadastrado, então enviar para a página da lista de pedidos
        if ($objpedido->cadastrar()) {
            header("Location: http://localhost/ecommerce/views/pedidos/lista_pedidos.php");
        }
    }
}
?>
