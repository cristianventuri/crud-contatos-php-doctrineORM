### CRUD - PHP | Doctrine 
Trata-se de um sistema de contatos, utilizando PHP, JS, HTML, CSS e Banco de Dados. Este sistema utiliza o padrão MVC em conjunto com Doctrine ORM para manipulação do banco de dados.

## Instalar as dependências
```shell
  composer install
```

## Criar e iniciar o banco
```shell
  vendor/bin/doctrine orm:schema-tool:create
```

## Iniciar no server PHP
```shell
  php -S localhost:8000 -t src
```