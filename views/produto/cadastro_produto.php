<?php 
    session_start(); // Inicia a sessão

    // Verifica se o usuário está logado
    if (!isset($_SESSION['usuarioLogged']) || $_SESSION['usuarioLogged'] !== true) {
        header("Location: /ecommerce/index.php"); // Redireciona para a página de login (index.php)
        exit;
    }

    // Verifica se o dispositivo é o mesmo do login
    if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] !== $_SERVER['REMOTE_ADDR']) {
        echo "Você não pode acessar esta página de um dispositivo diferente.";
        exit;
    }

    // Caminho para o controlador
    $path = $_SERVER["DOCUMENT_ROOT"] . '/ecommerce';
    
    // Inclui o arquivo da classe Produto
    include_once($path . '/models/produto.php');
    
    // Inclui o arquivo do controlador de produto
    include_once($path . '/controllers/produto_controller.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="../../styles/styles.css">
</head>
<body>
    <form action="" method="post" class="cadastro-produto-form" enctype="multipart/form-data">
        <label for="valor">Valor</label>
        <input type="text" name="valor" id="valor">
        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria">
        <label for="quantidade">Quantidade:</label>
        <input type="text" name="quantidade" id="quantidade">
        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" id="imagem">
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao"></textarea>
        <button type="submit" name="cadastrar" id="produto-btn">Cadastrar Produto</button>
    </form>

    <?php 
        // Verifica se o formulário foi enviado
        if(isset($_POST["cadastrar"])){
            $objproduto = new Produto(); // Cria um novo produto
            
            // Define os atributos do produto
            $objproduto->setDescricao($_POST["descricao"]);
            $objproduto->setValor($_POST["valor"]);
            $objproduto->setCategoria($_POST["categoria"]);
            $objproduto->setQuantidade($_POST["quantidade"]);
            
            $controllerproduto = new ProdutoController(); // Cria o controlador de produto
            $resposta = $controllerproduto->cadastraProduto($objproduto);  // Recebe a resposta do cadastro
            
            // Se houver resposta, exibe
            if ($resposta == "Sucesso") {
                header("Location: http://localhost/ecommerce/views/inicio.php");
            } else{
                echo $resposta;
            }
        }
    ?>
</body>
</html>
