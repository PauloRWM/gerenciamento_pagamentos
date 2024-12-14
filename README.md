
<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# Gerenciador de Pagamentos com StarkBank

Este projeto foi desenvolvido para um teste técnico e utiliza o Laravel junto ao Docker.

## Pré-requisitos

Antes de começar, instale os seguintes programas:

- Docker
- Docker Compose

Verifique a instalação executando os comandos que retornam as versões dos programas.

## Autenticação

As credenciais StarkBank são necessárias para autenticação. Configure as seguintes variáveis no arquivo `.env`:

- `PRIVATE_KEY`: Sua chave privada (copie e cole o conteúdo da sua chave privada aqui).
- `PROJECT_ID`
- `ENVIRONMENT`

Para mais detalhes sobre autenticação, consulte a [documentação da StarkBank](https://starkbank.com/docs/api#introduction).

## Instalação

1. Clone o repositório:
   ```bash
   git clone [URL do repositório]
   ```
2. Navegue até o diretório do projeto:
   ```bash
   cd [nome-do-diretório]
   ```
3. Execute o Docker Compose para construir e iniciar os contêineres:
   ```bash
   docker-compose up
   ```

## Configuração do Webhook

Configure a URL do webhook conforme o ambiente:

- **Produção**: Defina a `APP_URL` no ambiente de produção.
- **Desenvolvimento**:
  ```plaintext
  http://localhost:8000/api/webhook
  ```

Diga as instruções abaixo para setar a url de webhook no starkbank:

1 - Acesse sua conta
2 - Navegue ate integrações
3 - Clique em webhook
4 - Clique em "Novo Webhook", em Subscriptions: escolha "Transfer" e em URL cole a sua url de webhook

Obs: Se voce deseja testar com o webhook starkbank, public este projeto. Para Fins de testes, deixei duas amostras de req do webhook no postman, uma de transferencia bem sucedida e uma de mal sucedida



## Criação de Pagamentos via CURL

Execute o seguinte comando para criar uma transferência:

```bash
curl --location 'http://localhost:8000/api/createPayment' \
--header 'Content-Type: application/json' \
--data '{
    "bankCode": "001",
    "branch": "0001",
    "account": "123456-7",
    "amount": 1000,
    "name": "Fulano de Tal",
    "document": "000.000.000-00"
}'
```

## URL de Notificação

Configure a `URL_NOTIFICATION` no arquivo `.env` para as notificações.


## Observação
Para filas, optei em usar o db, mas poderia trabalhar com o REDIS. Decidi isso para diminuir a dependencia 
de serviços externos (aplicação redis), mas em um ambiente de produção com alto fluxo, é recomendado o uso do REDIS.


## Contato

Para esclarecimentos, entre em contato através do e-mail: paulox.tec@gmail.com

---
