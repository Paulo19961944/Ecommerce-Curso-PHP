<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Ecommerce</title>
    <link rel="stylesheet" href="../../styles/styles.css">
</head>
<body>
    <form action="" method="post" class="cadastro-form">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome">
        <label for="password">Senha:</label>
        <input type="password" name="senha" id="senha">
        <button type="submit" name="logar">Entrar</button>
        <button name="cadastrar">Cadastrar</button>
    </form>
</body>
</html>

<?php 
    $path = $_SERVER["DOCUMENT_ROOT"] . '/ecommerce'; // Caminho Padrão da Página
    include_once($path . '/controllers/usuario_controller.php'); // Importa o Controller

    // Se o botão for clicado
    if(isset($_POST["cadastrar"])){
        $objusuario = new Usuario(); // Retorna novo usuário
        
        // Define Email e Senha
        $objusuario->setNome($_POST["nome"]);
        $objusuario->setEmail($_POST["email"]);
        $objusuario->setSenha(senha: $_POST["senha"]);

        $controllerusuario = new UsuarioController(); // Importa o Controller
        $resposta = $controllerusuario->cadastraUsuario($objusuario); // Chama o Cadastro de Usuario

        if($resposta == "Sucesso"){
            header("Location: http://localhost/ecommerce/views/inicio.php");
        } 
        
        else{
            echo $resposta;
        }
    }
?>