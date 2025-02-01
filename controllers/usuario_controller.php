<?php 
$path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce"; // Caminho da Raiz do Documento
include_once($path . '/models/usuario.php'); // Importa o Model

class UsuarioController{
    // Função para Cadastrar o Usuario
    public function cadastraUsuario($objusuario){
        $objusuario->setNome($_POST["nome"]);  // Define um Nome
        $objusuario->setEmail($_POST["email"]);  // Define o Email
        $objusuario->setSenha($_POST["senha"]);  // Define a Senha do Usuario

        // Validações
        if(empty($objusuario->getNome()) || strlen($objusuario->getNome()) > 100){
            echo "Nome Inválido";
        }
        else if(empty($objusuario->getEmail()) || strlen($objusuario->getEmail()) > 100){
            echo "Email Inválido";
        }
        else if(empty($objusuario->getSenha()) || strlen($objusuario->getSenha()) > 100){
            echo "Senha Inválida";
        }
        else{
            $objusuario->Cadastrar(); 
            return "Sucesso"; 
        }
    }

    // Função de fazer o Login
    public function login($objusuario, $objproduto, $objpedido){
        // Verifica se o email e senha são válidos
        if(empty($objusuario->getEmail()) || strlen($objusuario->getEmail()) > 100){
            return "Email Inválido";
        }
    
        if(empty($objusuario->getSenha()) || strlen($objusuario->getSenha()) > 100){
            return "Senha Inválida";
        }
    
        $loginResult = $objusuario->Login(); // Faz o Login do Usuário
    
        if ($loginResult === true) {
            // Registra o login do usuário
            $_SESSION['usuarioLogged'] = true; // Define o Usuario como True
            $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR']; // Armazena o IP do dispositivo
            $_SESSION["usuario_id"] = $objusuario->getId(); // Armazena o Usuario_id
            $_SESSION["produto_id"] = $objproduto->getId(); // Armazena o Produto_id
            $_SESSION["pedido_id"] = $objpedido->getId(); // Armazena o Pedido_id

            return true;
        } else {
            return $loginResult;
        }
    }    

    // Função para Validar o Usuário
    public function validaUsuario($objusuario){
        // Verifica se o Email e a Senha são Válidos
        if(validaEmail($objusuario->getEmail()) && validaSenha($objusuario->getSenha())){
            $objusuario->setUsuarioLogged(true); // Define o Usuario Logged como True
            return $objusuario->Login(); // Chama o método de login
        }
        if(empty($objusuario->getSenha()) || strlen($objusuario->getSenha()) > 100){
            return "Senha Inválida";
        }
    }
}

// Função para validar o email
function validaEmail($email){
    // Verifica se o email não está vazio e se tem no máximo 100 caracteres
    if(empty($email)){
        echo "O email é obrigatório";
        return false;
    } 
    else if(strlen($email) > 100){
        echo "O email deve ter no máximo 100 caracteres";
        return false;
    }
    return true;
}

// Função para validar a senha
function validaSenha($senha){
    // Verifica se a Senha não está vazia e se não tem mais de 100 caracteres
    if(empty($senha)){
        echo "A senha é obrigatória";
        return false;
    } 
    else if(strlen($senha) > 100){
        echo "A senha deve ter no máximo 100 caracteres";
        return false;
    }
    return true;
}
?>
