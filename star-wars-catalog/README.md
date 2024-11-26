# Star Wars Catalog - Instruções de Instalação

## Pré-requisitos
- PHP 7.x ou superior
- MySQL 5.7 ou superior
- Servidor Apache ou ambiente com suporte a PHP
- Acesso à internet para consulta à API de filmes (SWAPI)

## Passo a Passo de Instalação

### 1. Clone o repositório ou extraia o arquivo compactado

- Se o repositório foi clonado, certifique-se de que todos os arquivos estão na pasta do servidor.

### 2. Importe o banco de dados
- Crie um banco de dados no MySQL. (nome sugerido:star_wars_catalog)
- Importe o arquivo `database_dump.sql` usando o comando:
  ```bash
  mysql -u seu_usuario -p star_wars_catalog < database_dump.sql

### 3. 

Inicie o servidor Apache e navegue até a página inicial do projeto, como http://localhost/star-wars-catalog/index.html
