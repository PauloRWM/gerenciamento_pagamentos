<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>




# Gerenciador de pagamentos com STARKBANK

Projeto desenvolvido para teste tecnico

## Pré-requisitos

Antes de iniciar, certifique-se de ter instalado:

- Docker
- Docker Compose

Você pode verificar a instalação com os seguintes comandos:

```bash
docker --version
docker-compose --version
```

Se esses comandos não retornarem a versão instalada, você precisará instalar o Docker e o Docker Compose.

## Instalação

Para colocar o projeto em funcionamento, siga estes passos:

1. Clone o repositório:
   ```bash
   git clone [URL do repositório]
   ```
2. Navegue até o diretório do projeto:
   ```bash
   cd [nome-do-diretório]
   ```
3. Execute o Docker Compose:
   ```bash
   docker-compose up
   ```

Isso construirá as imagens necessárias e iniciará os contêineres definidos no arquivo `docker-compose.yml`.

## Configuração de Webhook

A URL do webhook é configurada com base no ambiente em que o projeto está sendo executado:

- **Produção:** Configure a URL de webhook no ambiente de produção usando a variável de ambiente `APP_URL`.
- **Desenvolvimento:** Para testes locais, use:
  ```plaintext
  http://localhost:8000/api/webhook
  ```

Adicione `/api/webhook` ao `APP_URL` para formar a URL completa do webhook.

## Uso






## Contato

paulox.tec@gmail.com

---
