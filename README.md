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
