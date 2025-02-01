<?php 

$path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce'; // Define o caminho principal da página
include_once($path."/conexao.php"); // Importa a Classe Conexão

class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $endereco;
    private $usuarioLogged;

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;   
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setUsuarioLogged($usuarioLogged){
        $this->usuarioLogged = $usuarioLogged;
    }

    public function Login(){
        $objconexao = new Conexao(); // Instância do Objeto Conexão
        $conexao = $objconexao->getConexao(); // Conexão com o DB

        // Busca o ID, Nome, Email, Senha da Tabela Usuários se o email for do usuário
        $sql = "SELECT ID, Nome, Email, Senha FROM Usuarios WHERE email = '".$this->getEmail()."'";

        $resposta = $conexao->query($sql); // Insere o Comando SQL
        $usuario = $resposta->fetch_assoc(); // Busca a Resposta do Usuário

        // Validação do usuário
        if(!$usuario){
            return "Email não cadastrado";
        } 
        else if($usuario['Senha'] != $this->getSenha()){
            return "Senha Incorreta";
        }
        else{
            $this->setId($usuario["ID"]);
            return true; // Retorna true se login for bem-sucedido
        }
    }

    // Cadastra o Usuário
    public function Cadastrar(){
        $objconexao = new Conexao(); // Instância da Classe Conexão
        $conexao = $objconexao->getConexao(); // Conecta com o DB

        // Insere na Tabela Usuarios o Nome, Email e Senha
        $sql = "INSERT INTO Usuarios (Nome, Email, Senha) VALUES('$this->nome', '$this->email', '$this->senha')";

        // Verifica se a conexão foi bem sucedida
        if(mysqli_query($conexao, $sql)){
            return "Sucesso";
        } else{
            return "Erro";
        }
        mysqli_close($conexao);
    }
}
?>
