<?php 
$path = $_SERVER["DOCUMENT_ROOT"]. "/ecommerce"; // Caminho da Raiz do Documento
include_once($path . '/models/usuario.php'); // Importa o Model

class UsuarioController{
    // Função para Cadastrar o Usuario
    public function cadastraUsuario($objusuario){
        $objusuario->setNome($_POST["nome"]);  // Define um Nome
        $objusuario->setEmail($_POST["email"]);  // Define o Email
        $objusuario->setSenha($_POST["senha"]);  // Define a Senha do Usuario

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
    public function login($objusuario){
        // Verifica se o email e senha são válidos
        if(empty($objusuario->getEmail()) || strlen($objusuario->getEmail()) > 100){
            return "Email Inválido";
        }
    
        if(empty($objusuario->getSenha()) || strlen($objusuario->getSenha()) > 100){
            return "Senha Inválida";
        }
    
        $loginResult = $objusuario->Login();
    
        if ($loginResult === true) {
            // Registra o login do usuário
            $_SESSION['usuarioLogged'] = true; // A sessão agora é definida corretamente
            $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR']; // Armazena o IP do dispositivo
            return true;
        } else {
            return $loginResult;
        }
    }    

    // Função para Validar o Usuário
    public function validaUsuario($objusuario){
        if(validaEmail($objusuario->getEmail()) && validaSenha($objusuario->getSenha())){
            $objusuario->setUsuarioLogged(true);
            return $objusuario->Login(); // Chama o método de login
        }
        if(empty($objusuario->getSenha()) || strlen($objusuario->getSenha()) > 100){
            return "Senha Inválida";
        }
    }
}

// Função para validar o email
function validaEmail($email){
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
