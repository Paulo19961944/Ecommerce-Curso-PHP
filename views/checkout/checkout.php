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
        <section class="main-container">
            <h1 class="checkout-title">Checkout</h1>
        </section>
    </main>

    <form action="" method="post" class="checkout-form">
        <label for="cep">CEP</label>
        <input type="text" name="cep" id="cep">
        <label for="rua">Rua</label>
        <input type="text" name="rua" id="rua">
        <label for="numero-rua">Numero</label>
        <input type="text" name="numero-rua" id="numero-rua">
        <label for="cidade">Cidade</label>
        <input type="text" name="cidade" id="cidade">
        <label for="estado">Estado</label>
        <input type="text" name="estado" id="estado">
        <button name="finalizar-checkout" class="finalizar-checkout">Faça seu Pedido</button>
        <button type="button" onclick="window.location.href='http://localhost/ecommerce/views/carrinho/lista_carrinho.php'" class="voltar">Voltar</button>
    </form>

    <?php 
        session_start();
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /ecommerce/views/login.php");
            exit();
        }

        $path = $_SERVER["DOCUMENT_ROOT"] . "/ecommerce";
        include_once($path . "/controllers/pedidos_controller.php");
        $pedidos_controller = new PedidosController ();

        if(isset($_POST["finalizar-checkout"])){
            $pedidos_controller->AdicionarPedido();
        }
    ?>

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
    <script>
        document.getElementById('cep').addEventListener('input', () => {
            const cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove qualquer caracter não numérico

            // Verifica se o CEP tem exatamente 8 caracteres
            if (cep.length === 8) {
                // Criando a requisição AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../../controllers/checkout_controller.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                // Função para tratar a resposta
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.erro) {
                            alert('CEP não encontrado');
                        } else {
                            // Preencher os campos com os dados retornados pela API
                            document.getElementById('rua').value = response.rua;
                            document.getElementById('cidade').value = response.cidade;
                            document.getElementById('estado').value = response.estado;
                        }
                    } else {
                        alert('Erro ao buscar o CEP');
                    }
                };

                // Enviar o CEP para a requisição
                xhr.send(`cep=${cep}`);
            }
        });
    </script>

</body>

</html>
