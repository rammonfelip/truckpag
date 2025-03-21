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
Execute o comando
```bash
  docker-compose up -d
```

O projeto estará disponível em http:localhost:9000

## 2. Executar o Comando de Sincronização

```bash
  docker exec -it truckpag_app artisan importar-produtos
```
## 3. Rotas de API
## Documentação da API

#### Listagem de produtos

```http
  GET /api/produtos
```
Possui paginação e listagem
```json
{
    "code": "0000000000017",
    "product_name": "Vitória crackers",
    "url": "http://world-en.openfoodfacts.org/product/0000000000017/vitoria-crackers",
    "brands": "",
    "categories": "",
    "status": "published",
    "imported_t": 1742527921,
    "image_url": "https://static.openfoodfacts.org/images/products/000/000/000/0017/front_fr.4.400.jpg",
    "origins": "",
    "last_modified_t": "1561463718",
    "last_modified_datetime": "2019-06-25T11:55:18Z",
    "imported_datetime": "2025-03-21T03:32:01.735000Z",
    "created_at": "2025-03-21T03:32:01.885000Z",
    "updated_at": "2025-03-21T03:32:01.885000Z"
}
```

#### Retorna Produto
Retorna o produto solicitado pelo seu {code}
```http request
    GET /api/produto/{code}
```

#### Atualiza Produto
Atualiza os dados de um produto
```http request
    PUT /api/produto/{code}
```

#### Apagar Produto
Modifica o status do produto para TRASH
```http request
    DELETE /api/produto/{code}
```

## 4. Rodando os Testes
```bash
  php artisan test
```
