<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Carrinho</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../styles/styles.css">
</head>

<body>
    <header>
        <section class="header-container">
            <img src="../../public/images/Logo-Ecommerce-Sem-Fundo.png" alt="Logotipo da Loja" id="logo">
            <nav class="menu-container">
                <ul id="menu">
                    <li><a href="http://localhost/ecommerce/views/inicio.php">Home</a></li>
                    <li><a href="http://localhost/ecommerce/views/produto/listagem_produtos.php">Produtos</a></li>
                    <li><a href="#">Pedidos</a></li>
                    <li><a href="http://localhost/ecommerce/views/carrinho/lista_carrinho.php">Carrinho</a></li>
                </ul>
            </nav>
        </section>
    </header>

    <main>
        <section class="carrinho-container">
            <h1 class="carrinho-title">Meu Carrinho</h1>
            <?php
            $path = $_SERVER["DOCUMENT_ROOT"] . '/ecommerce';
            include_once($path . '/controllers/carrinhos_controller.php');

            $objcarrinhos = new Carrinhos();
            $carrinhosController = new CarrinhosController();
            $produtosCarrinho = $carrinhosController->listaProdutos($objcarrinhos)['produtos'];
            $valorTotalCarrinho = $carrinhosController->listaProdutos($objcarrinhos)['valorTotal'];
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Preço Total</th>
                    </tr>
                </thead>
                <?php 
                foreach ($produtosCarrinho as $carrinho) {
                    // Calculando o preço total para esse produto
                    $precoTotalProduto = $carrinho['Preco'] * $carrinho['Quantidade'];
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td> Produto ' . $carrinho['Produto_id'] . '</td>';
                    echo '<td>' . $carrinho['Quantidade'] . '</td>';
                    echo '<td>R$ ' . number_format($carrinho['Preco'], 2, ',', '.') . '</td>';
                    echo '<td>R$ ' . number_format($precoTotalProduto, 2, ',', '.') . '</td>';
                    echo '</tr>';
                    echo '</tbody>';
                }
                ?>
                <tfoot>
                    <tr>
                        <td colspan="1">Total</td>
                        <td colspan="2"></td>
                        <td colspan="1">R$ <?php echo number_format($valorTotalCarrinho, 2, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>
            <form action="" method="post" class="carrinho-form">
                <button class="finalizar-btn" name="finalizar">Finalizar Pedido</button>
                <button class="voltar-btn" name="voltar">Voltar</button>
            </form>
        </section>
    </main>

    <footer>
        <section class="footer-container">
            <article class="horario">
                <section class="row">
                    <i class="fa-solid fa-clock"></i>
                </section>
                <p>Horario de Funcionamento - 08:00 até as 18:00</p>
                <p>Entregamos para Todo o Brasil</p>
            </article>
            <article class="local">
                <section class="row">
                    <i class="fa-solid fa-location-pin"></i>
                </section>
                <p>Endereço: Rua Minas Gerais, 452, Loja 1</p>
                <p>Cidade: São Paulo</p>
            </article>
            <article class="contato">
                <section class="row">
                    <i class="fa-solid fa-mobile"></i>
                </section>
                <p>Email: ecommerce@gmail.com</p>
                <p>Whatsapp: (11)93349-7042</p>
            </article>
        </section>
    </footer>
</body>

</html>
