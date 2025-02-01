<?php 
$path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce"; // Define o Caminho Principal
include_once($path . '/models/pedidos.php'); // Importa a Classe Pedidos
include_once($path . 'models/produtos_pedidos.php'); // Importa a Classe Produto Pedidos

class PedidosController {
    // Adiciona um Pedido
    public function AdicionarPedido() {
        session_start(); // Inicializa a Sessão

        // Se não foi definido o usuario_id, então retornar para a página de login
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /ecommerce/views/login.php");
            exit();
        }

        // Instância da Classe Pedidos e Produto Pedidos
        $objpedido = new Pedidos(); 
        $objprodutopedido = new ProdutosPedidos();

        // Captura as Sessões do Produto ID e do Pedido ID
        $produto_id = $_SESSION["produto_id"];
        $pedido_id = $_SESSION["pedido_id"];

        // Se o Pedido foi cadastrado, então enviar para a página da lista de pedidos
        if ($objpedido->cadastrar()) {
            $objprodutopedido->cadastrar($produto_id, $pedido_id); // Cadastra na Tabela Produtos_Pedidos
            header("Location: http://localhost/ecommerce/views/pedidos/lista_pedidos.php");
        }
    }
}
?>
