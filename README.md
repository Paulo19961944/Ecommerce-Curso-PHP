# PROJETO DE ECOMMERCE COM PHP 

Esse é meu primeiro projeto que estou fazendo no Curso EAD da Instituição do Senac. O projeto tem como objetivo desenvolver habilidades com PHP e MYSQL.

## COMO UTILIZAR O PROJETO
Primeiramente devemos fazer um clone desse diretório com o seguinte comando:

```bash
    git clone https://github.com/Paulo19961944/Ecommerce-Curso-PHP ecommerce
```

Depois de clonado o repositório, precisamos entrar na nossa pasta com o seguinte comando:

```bash
    cd ecommerce
```

Dentro de nossa pasta ecommerce devemos instalar o composer com o comando:

```bash
    composer install
```
**OBS:** Certifique-se que tenha o composer instalado em sua máquina

## CRIANDO A TABELA DE USUÁRIOS

Para criar a tabela de usuários devemos seguir os seguintes passos:

1. Abra o seu XAMPP e habilite o Apache e o MYSQL
2. [Clique aqui para entrar no seu painel de administrador](http://localhost/phpmyadmin)
3. Clique no botão Novo
4. De o nome do Banco de Dados como ecommerce e clique em criar
5. Clique em SQL e insira o seguinte comando:
```sql
CREATE TABLE Usuarios(
    ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Nome varchar(100) NOT NULL,
    Email varchar(100) NOT NULL,
    Senha varchar(100) NOT NULL,
    Endereco varchar(100) NOT NULL,
    Chave varchar(255) NOT NULL
);
```

## CRIANDO A TABELA DE PRODUTOS
1. Clique no ecommerce
2. Clique em SQL e insira o seguinte comando:

```sql
CREATE TABLE Produtos(
    ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Descricao varchar(250) NOT NULL,
    Valor double NOT NULL,
    Categoria varchar(100),
    Quantidade double NOT NULL
);
```

## CRIANDO A TABELA DE PEDIDOS

1. Clique no ecommerce
2. Clique em SQL e insira o seguinte comando:

```sql
CREATE TABLE Pedidos(
    ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Valor double NOT NULL,
    Status varchar(100),
    Usuario_id int NOT NULL,
    FOREIGN KEY (Usuario_id) REFERENCES Usuarios(id)
);
```

## CRIANDO A TABELA DE CARRINHOS
1. Clique no ecommerce
2. Clique em SQL e insira o seguinte comando:

```sql
CREATE TABLE Carrinhos(
    ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Usuario_id int NOT NULL,
    Produto_id int NOT NULL,
    Quantidade double NOT NULL,
    FOREIGN KEY (Usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (Produto_id) REFERENCES Produtos(id)
);
```

## CRIANDO A TABELA DE PRODUTOS PEDIDOS

1. Clique no ecommerce
2. Clique em SQL e insira o seguinte comando:

```sql
CREATE TABLE Produtos_Pedidos(
    ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Produto_id int NOT NULL,
    Pedido_id int NOT NULL,
    Valor double NOT NULL,
    FOREIGN KEY (Produto_id) REFERENCES Produtos(id),
    FOREIGN KEY (Pedido_id) REFERENCES Pedidos(id)
);
```

## DECLARANDO VARIÁVEIS DE AMBIENTE
Dentro de nosso projeto, necessitamos instalar as váriáveis de ambiente para que funcione em nosso projeto, para isso criamos um _arquivo .env_ na raiz de nosso diretório.

```bash
    touch .env
```

Depois de criado o arquivo, nomeamos conforme a tabela abaixo:


| Nome da Variável de Ambiente | Valor         |
|------------------------------|---------------|
|HOST                          | Seu Servidor  |
|             DB            |Seu Banco de Dados|
|USUARIODB      | Seu Usuario do Banco de Dados|
|SENHADB          | Sua Senha do Banco de Dados|

Feito isso podemos começar a testar o nosso código.


**OBS:** O projeto deve estar na pasta htdocs do seu XAMPP, será necessário a instalação do XAMPP. Em breve farei um vídeo mostrando a instalação do XAMPP e de como utilizar em seu projeto


## TESTANDO O CÓDIGO
1. Abra o seu XAMPP e clique em MYSQL e no Apache para inicializar o seu servidor
2. [Clique Aqui para inicializar o seu Servidor](http://localhost/ecommerce)
3. Cadastre o seu usuário, como ainda estou mexendo [Clique Aqui](http://localhost/ecommerce/views/usuario/cadastro_usuario.php)
4. Cadastrado o usuário é só fazer o login
5. Explore as funcionalidades do código


## CONCLUSÃO
Foi um projeto bacana, porém ele não está 100% pronto e estou mexendo nele aos poucos. Pra mim foi desafiador pelo sentido que nunca fiz uma aplicação dessa em PHP Puro, e estou em constante aprendizado, porém me sinto realizado ao fazer um projeto desses
