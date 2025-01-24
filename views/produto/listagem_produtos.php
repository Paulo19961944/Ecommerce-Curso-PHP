<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <section class="product-container">
            <h1 class="product-title">Produtos</h1>
            <?php
            $path = $_SERVER["DOCUMENT_ROOT"] . '/ecommerce';
            include_once($path . '/controllers/produto_controller.php');
            include_once($path . '/controllers/carrinhos_controller.php');
            session_start();

            $objproduto = new Produto();
            $produtoController = new ProdutoController();
            $produtos = $produtoController->listaProdutos($objproduto);
            ?>
    
            <?php
            foreach ($produtos as $produto) {
                echo "<article class=\"product\">";
                    echo "<h2>";
                        echo "Produto ";
                        echo $produto['ID'];
                    echo "</h2>";

                    // Exibe a imagem associada ao produto
                    if (isset($produto['imagem']) && !empty($produto['imagem'])) {
                        echo "<img src=\"" . $produto['imagem'] . "\" alt=\"Imagem do Produto\" class=\"produto-imagem\">";
                    } else {
                        echo "<p>Imagem não disponível</p>";
                    }                        

                    echo "<p>";
                        echo "<b>Descrição do Produto: </b>";
                        echo $produto['Descricao'];
                    echo "</p>";
                    echo "<p>";
                        echo "<b>Preço: </b>";
                        echo $produto['Valor'];
                        echo " R$";
                    echo "</p>";
                    echo "<p>";
                        echo "<b>Categoria: </b>";
                        echo $produto['Categoria'];
                    echo "</p>";
                    echo "<p>";
                        echo "<b>Quantidade em Estoque: </b>";
                        echo $produto['Quantidade'];
                    echo "</p>";
                    echo "<form action=\"\" method=\"post\">";
                        echo '<input type="hidden" name="produto_id" value="' . $produto['ID'] . '">';
                        echo "<button class=\"comprar\" name=\"comprar\">Compre Agora</button>";
                    echo "</form>";
                echo "</article>";
            }
            ?>
            <?php 
            if (isset($_POST["comprar"])) {
                $produtoId = $_POST["produto_id"]; // Pega o produto ID do formulário
                $usuarioId = $_SESSION["usuario_id"]; // Usuário já está na sessão
                $objcarrinho = new CarrinhosController();
                $objcarrinho->adicionarProduto($produtoId, $usuarioId);
            }
            ?>

        </section>

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
