# Sistema de Gerenciamento de Serviços

Este projeto é um sistema simples de gerenciamento de serviços, desenvolvido em PHP, que permite adicionar, editar, deletar e visualizar serviços. Ele utiliza MySQL como banco de dados para armazenar as informações dos serviços.

## Funcionalidades

- **Adicionar Serviço**: Permite adicionar novos serviços ao sistema.
- **Editar Serviço**: Permite editar informações de serviços existentes.
- **Deletar Serviço**: Permite deletar serviços do sistema.
- **Visualizar Serviços**: Permite visualizar informações de todos os serviços cadastrados.
- **Visualizar Serviço por ID**: Permite visualizar informações de um serviço específico através de seu ID.

## Estrutura do Projeto

- `add_service.php`: Endpoint para adicionar novos serviços.
- `edit_service.php`: Endpoint para editar serviços existentes.
- `delete_service.php`: Endpoint para deletar serviços.
- `get_service.php`: Endpoint para obter informações de um serviço específico por ID.
- `get_services.php`: Endpoint para obter informações de todos os serviços.
- `includes/conexao.php`: Arquivo de configuração da conexão com o banco de dados.

## Configuração do Banco de Dados

Certifique-se de criar a tabela `servicos` no seu banco de dados MySQL. Abaixo está um exemplo de como a tabela pode ser criada:

```sql
CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_projeto VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    empresa VARCHAR(255) NOT NULL,
    concessionaria VARCHAR(255) NOT NULL,
    metragem_total INT NOT NULL,
    quantidade_postes INT NOT NULL,
    numero_art VARCHAR(255) NOT NULL,
    engenheiro VARCHAR(255) NOT NULL,
    responsavel_empresa VARCHAR(255) NOT NULL,
    responsavel_comercial VARCHAR(255) NOT NULL
);
```

Instalação
Clone este repositório para o seu servidor local:

```sh
git clone https://github.com/seu-usuario/sistema-de-servicos.git
```

Configure a conexão com o banco de dados no arquivo includes/conexao.php:

```php
<?php
$servername = "seu_servidor";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
```

Certifique-se de que a tabela servicos foi criada conforme a seção de Configuração do Banco de Dados.

Uso
Adicionar Serviço
Endpoint: add_service.php

Método: POST

Corpo da Requisição (JSON):

```json
Copiar código
{
    "nome_projeto": "Nome do Projeto",
    "cidade": "Cidade",
    "empresa": "Empresa",
    "concessionaria": "Concessionária",
    "metragem_total": 100,
    "quantidade_postes": 10,
    "numero_art": "123456",
    "engenheiro": "Engenheiro Responsável",
    "responsavel_empresa": "Responsável pela Empresa",
    "responsavel_comercial": "Responsável Comercial"
}
```
Editar Serviço
Endpoint: edit_service.php

Método: POST

Corpo da Requisição (JSON):

```json
Copiar código
{
    "id": 1,
    "nome_projeto": "Nome do Projeto Atualizado",
    "cidade": "Cidade Atualizada",
    "empresa": "Empresa Atualizada",
    "concessionaria": "Concessionária Atualizada",
    "metragem_total": 200,
    "quantidade_postes": 20,
    "numero_art": "654321",
    "engenheiro": "Engenheiro Responsável Atualizado",
    "responsavel_empresa": "Responsável pela Empresa Atualizado",
    "responsavel_comercial": "Responsável Comercial Atualizado"
}
```
Deletar Serviço
Endpoint: delete_service.php

Método: POST

Corpo da Requisição (JSON):

```json
Copiar código
{
    "id": 1
}
```
Visualizar Serviços
Endpoint: get_services.php

Método: GET

Visualizar Serviço por ID
Endpoint: get_service.php

Método: GET

Parâmetro de URL:

```bash
?id=1
```

Licença
Este projeto está licenciado sob a licença MIT. Consulte o arquivo LICENSE para obter mais informações.
