<?php 
    session_start(); // Inicia a sessão
    $path = $_SERVER["DOCUMENT_ROOT"] . '/ecommerce'; // Caminho Padrão da Página
    include_once($path . '/controllers/usuario_controller.php'); // Importa o Controller

    // Se o botão de login for clicado
    if(isset($_POST["logar"])){
        $objusuario = new Usuario(); // Cria um novo objeto Usuario
        
        // Define o email e a senha do usuário
        $objusuario->setEmail($_POST["email"]);
        $objusuario->setSenha($_POST["senha"]);
    
        $controllerusuario = new UsuarioController(); // Cria o controlador de usuário
        $resposta = $controllerusuario->login($objusuario); // Chama a validação e login do usuário
    
        if($resposta === true){
            // Redireciona para a página inicial após o login
            header("Location: /ecommerce/views/inicio.php");
            exit; // Não se esqueça de adicionar o exit após o redirecionamento
        } else {
            echo $resposta; // Exibe mensagem de erro
        }
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
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha">
        <button type="submit" name="logar">Entrar</button>
        <button name="cadastrar">Cadastrar</button>
    </form>
</body>
</html>
