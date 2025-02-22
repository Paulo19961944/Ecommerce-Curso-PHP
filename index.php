<?php 
    session_start(); // Inicia a sessão
    $path = $_SERVER["DOCUMENT_ROOT"] . '/ecommerce'; // Caminho Padrão da Página
    include_once($path . '/controllers/usuario_controller.php'); // Importa o Controller
    include_once($path . '/models/produto.php');
    include_once($path . '/models/pedidos.php');

    // Se o botão de login for clicado
    if(isset($_POST["logar"])){
        $objusuario = new Usuario(); // Cria um novo objeto Usuario
        
        // Define o email e a senha do usuário
        $objusuario->setEmail($_POST["email"]);
        $objusuario->setSenha($_POST["senha"]);

        // Objeto Produto
        $objproduto = new Produto();

        // Objeto Pedido
        $objpedido = new Pedidos();
    
        // Controller Usuario
        $controllerusuario = new UsuarioController(); // Cria o controlador de usuário
        $resposta = $controllerusuario->login($objusuario, $objproduto, $objpedido); // Chama a validação e login do usuário
    
        if($resposta === true){
            // Redireciona para a página inicial após o login
            header("Location: http://localhost/ecommerce/views/inicio.php");
            exit; // Não se esqueça de adicionar o exit após o redirecionamento
        } else {
            echo $resposta; // Exibe mensagem de erro
        }
    }

    else if(isset($_POST["cadastrar"])){
        header("Location: http://localhost/ecommerce/views/usuario/cadastro_usuario.php");
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Ecommerce</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <form action="" method="post" class="login-form">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha">
        <button type="submit" name="logar">Entrar</button>
        <button name="cadastrar">Cadastrar</button>
    </form>
</body>
</html>
