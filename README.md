# Desafio Coodesh - Truckpag

## Descrição

Uma API RESTful para gerenciamento de produtos, utilizando Laravel, MongoDB.

## Tecnologias Utilizadas

- **Linguagens**: PHP (8.2), JavaScript
- **Frameworks**: Laravel 12
- **Banco de Dados**: MongoDB (servidor online)

### Instalação
Clone o projeto

```bash
  git clone https://github.com/rammonfelip/truckpag
```

Entre no diretório do projeto

```bash
  cd truckpag
```

Crie um arquivo .env a partir do arquivo .env.example

```bash
  cp .env.example .env
```

Execute os seguintes comandos para construir o ambiente

```bash
composer install
php artisan key:generate
php artisan migrate
```

Isso irá instalar as dependências, gerar a chave da aplicação e executar as migrações no banco de dados.

Para iniciar o servidor

```bash
  php artisan serve --port=8080
```
Ou outra porta se preferir

## 2. Executar o Comando de Sincronização

```bash
  php artisan importar-produtos
```

## 3. Rodando os Testes
```bash
  php artisan test
```
