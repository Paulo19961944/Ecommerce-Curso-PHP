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

    // Chave e IV são agora dinâmicos e gerados aleatoriamente
    private $iv_length = 16;  // Tamanho do vetor de inicialização (IV) para AES-256-CBC

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

    // Método para criptografar a senha antes de armazená-la
    public function setSenha($senha){
        // Gera uma chave aleatória para cada usuário
        $key = openssl_random_pseudo_bytes(32);  // Gerando uma chave de 256 bits (32 bytes)

        // Gera um IV aleatório para a criptografia
        $iv = openssl_random_pseudo_bytes($this->iv_length);

        // Criptografa a senha
        $encrypted_password = openssl_encrypt($senha, 'AES-256-CBC', $key, 0, $iv);

        // Armazena a senha criptografada, o IV e a chave gerada (codificados em base64)
        $this->senha = base64_encode($encrypted_password . "::" . base64_encode($iv));
        $this->key = base64_encode($key);  // Armazena a chave em base64
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

    // Método para verificar se a senha fornecida pelo usuário é correta
    public function verificarSenha($senha, $userKey){
        // Separa a senha criptografada e o IV armazenado
        list($encrypted_password, $encrypted_iv) = explode("::", base64_decode($this->senha));
        $iv = base64_decode($encrypted_iv);

        // Descriptografa a senha usando a chave do usuário
        $key = base64_decode($userKey);  // A chave gerada e armazenada no banco
        $decrypted_password = openssl_decrypt($encrypted_password, 'AES-256-CBC', $key, 0, $iv);

        // Compara a senha fornecida com a senha descriptografada
        return $decrypted_password === $senha;
    }

    // Método de Login
    public function Login(){
        $objconexao = new Conexao(); // Instância do Objeto Conexão
        $conexao = $objconexao->getConexao(); // Conexão com o DB

        // Busca o ID, Nome, Email, Senha e Chave do usuário na tabela Usuarios
        $sql = "SELECT ID, Nome, Email, Senha, Chave FROM Usuarios WHERE email = '".$this->getEmail()."'";

        $resposta = $conexao->query($sql); // Insere o Comando SQL
        $usuario = $resposta->fetch_assoc(); // Busca a Resposta do Usuário

        // Validação do usuário
        if(!$usuario){
            return "Email não cadastrado";
        } 
        else if(!$this->verificarSenha($this->getSenha(), $usuario['Chave'])){
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

        // Insere na Tabela Usuarios o Nome, Email, Senha e a chave gerada
        $sql = "INSERT INTO Usuarios (Nome, Email, Senha, Chave) VALUES('$this->nome', '$this->email', '$this->senha', '$this->key')";

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
