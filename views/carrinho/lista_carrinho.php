<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles/inicio.css">
</head>

<body>
    <header>
        <section class="header-container">
            <img src="../public/images/Logo-Ecommerce-Sem-Fundo.png" alt="Logotipo da Loja" id="logo">
            <nav class="menu-container">
                <ul id="menu">
                    <li><a href="http://localhost/ecommerce/views/inicio.php">Home</a></li>
                    <li><a href="http://localhost/ecommerce/views/produto/listagem_produtos.php">Produtos</a></li>
                    <li><a href="#">Pedidos</a></li>
                    <li><a href="#">Carrinho</a></li>
                </ul>
            </nav>
        </section>
    </header>

    <main>
        <section class="carrinho-container">
            <?php ?>
        </section>
    </main>

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