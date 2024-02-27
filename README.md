# Projeto MundoWap Teste

Esta API fornece uma maneira de gerenciar lojas e seus endereços.

Baixe o código-fonte em um arquivo zip, ou, se você tiver o Git instalado, use o comando git clone. Escolha a opção que melhor se adapta às suas necessidades - **HTTPS, SSH, GitHub CLI**. Abaixo estão as configurações para o ambiente de desenvolvimento.

## Tecnologias usadas
 * PHP
 * CakePHP
 * MySQL
 * Composer
 * GIT
 * Docker
 * PHP unit
  
## Principais classes
 * StoresController.php
 * StoresTable.php
 * Store.php
 * StoresControllerTest.php
 * AddressesTable.php
 * Address.php
 * routes.php

## Começando

Para começar a utilizar a biblioteca em desenvolvimento, você precisa ter o seguinte configurado:

- Docker: Certifique-se de que o Docker está instalado e disponível no seu sistema. Você pode verificar se o PHP está instalado executando o seguinte comando:
``` bash
$  docker --version
```

- PHP: Certifique-se de que o PHP está instalado e disponível no seu sistema. Você pode verificar se o PHP está instalado executando o seguinte comando:
``` bash
$  php --version
```

- Composer: Certifique-se de que o Composer está instalado e disponível no seu sistema. Você pode verificar se o Composer está instalado executando o seguinte comando:
``` bash
$  composer --version
```

## Clonando o projeto

Escolha uma das opções abaixo ou baixe o projeto em formato zip:

``` bash
$    HTTPS - git clone https://github.com/hugojose39/omnipay-cielo-teste.git
$    SSH - git clone git@github.com:hugojose39/omnipay-cielo-teste.git
$    GitHub CLI - gh repo clone hugojose39/omnipay-cielo-teste
```

Quando o projeto estiver em seu computador, acesse sua pasta e execute os comandos no seu terminal:

1. Crie os arquivos .env.app e .env.db de acordo com os arquivos .env.*.example relacionados.
   
2. Construa a imagem do Docker com o comando abaixo:
    ```bash
    docker-compose build --force-rm
    ```

3. Para acessar a linha de comando da aplicação, execute o comando abaixo:
    **O comando docker compose exec --user=root app bash permite acessar o contêiner do aplicativo Docker como usuário root.**
    ```bash
    docker compose exec --user=root app bash
    ```

4. Na linha de comando da aplicação, instale as dependências da aplicação com o comando abaixo:
    ```bash
    composer install
    ```

5. Ainda na linha de comando da aplicação, execute o teste do StoresController com o comando abaixo:
    ```bash
    vendor/bin/phpunit tests/TestCase/Controller/StoresControllerTest.php
    ```

6. Para sair da linha de comando da aplicação, execute o comando abaixo:
    ```bash
    exit
    ```

7. Execute o comando abaixo para iniciar a aplicação:
    ```bash
    docker-compose up -d --remove-orphans
    ```

8. Execute o comando abaixo para parar a aplicação:
    ```bash
    docker-compose down
    ```

## Uso 
A aplicação deve ser acessível em `http://localhost:13001`.

O banco de dados deve ser acessível em `http://localhost:3306`.

## Endpoints

### A API fornece os seguintes endpoints:

POST /stores/create: Cria uma nova loja.

GET /stores/index: Lista todas as lojas. 

GET /stores/show/{id}: Obtém uma loja específica. 

PUT /stores/update/{id}: Atualiza uma loja específica. 

DELETE /stores/delete/{id}: Exclui uma loja específica.

## Exemplos:

### Listar todas as lojas

curl -X GET

`http://localhost:13001/stores/index`

### Criar uma nova loja

curl -X POST

- H "Content-Type: application/json"
- d `{ "name": "Loja Teste", "addresses": [{"postal_code": "01001000", "street_number": "231"}]}`

`http://localhost:13001/stores/create`

### Listar uma loja específica

curl -X GET

`http://localhost:13001/stores/show/1`

### Atualizar uma loja

curl -X PUT

- H "Content-Type: application/json"
- d `{ "name": "Loja Teste2", "addresses": [{"postal_code": "01001001", "street_number": "231"}]}`

`http://localhost:13001/stores/update/1`

### Excluir uma loja

curl -X DELETE

`http://localhost:13001/stores/delete/1`

## Possíveis problemas

Durante o processo de configuração e utilização da biblioteca, esteja atento aos seguintes possíveis problemas:

* Tentar utilizar o Composer sem ter o PHP instalado previamente.
* Clonar o projeto sem ter instalado o GIT anteriormente.
* Executar os comandos do Composer fora do diretório do projeto.

**Observação: Todas as classes, inclusive os testes, possuem comentários que explicam sua funcionalidade.**

Seguindo esses passos, você terá o código da biblioteca instalado corretamente, com suas dependências e testes executados de maneira apropriada.

Se ocorrerem problemas durante o processo de configuração, verifique se todas as dependências foram instaladas corretamente e se todas as etapas foram seguidas adequadamente.