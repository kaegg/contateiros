# Contateiros

Sistema web completo para gerenciamento de contatos, com frontend em Vue.js e backend em Laravel.

---

## Tecnologias Utilizadas

- **Node.js**: v22.17.0  
- **NPM**: versão mais recente compatível com o Node.js 22.17.0  
- **PHP**: v8.4.8  
- **Laravel**: 10.x  
- **Vue.js**: 3  
- **MySQL**: 8+

---

## Guia de Instalação

### 1. Clonar o repositório

```bash
git clone https://github.com/kaegg/contateiros.git
cd contateiros
```

---

### 2. Configuração do Node.js com NVM

Caso você **não tenha a versão correta do Node.js instalada**, siga os passos abaixo:

#### 2.1 Instale o NVM (Node Version Manager)

Baixe o instalador do NVM para Windows neste link:

🔗 [https://github.com/coreybutler/nvm-windows/releases](https://github.com/coreybutler/nvm-windows/releases)

#### 2.2 Instale e use a versão correta do Node.js

```bash
nvm install 22.17.0     # Instala o Node.js 22.17.0
nvm use 22.17.0         # Define essa versão como ativa
npm install -g npm      # Atualiza o NPM para a versão compatível
```

---

### 3. Configuração do Backend (Laravel)

```bash
cd backend
composer install
cp .env.example .env
```

#### 3.1 Configurar o banco de dados

Edite o arquivo `.env` com suas credenciais:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

#### 3.2 Criar e popular as tabelas do banco

```bash
php artisan migrate
php artisan db:seed
```

#### 3.3 Iniciar servidor backend

```bash
php artisan serve
```

> O backend estará acessível em: **http://localhost:8000**

---

### 4. Configuração do Frontend (Vue.js)

```bash
cd ../frontend
npm install
```

#### 4.1 Iniciar servidor frontend

```bash
npm run dev
```

> O frontend estará acessível em: **http://localhost:5173**

---

### 5. Rodar o projeto sem alternar entre pastas

Para rodar o projeto inteiro sem a necessidade de alternar entre as pastas frontend e backend basta rodar os seguintes comandos dentro da pasta raíz do projeto

```bash
npm install --save-dev concurrently
npm run dev:all
```

---

## Documentação da API

Após iniciar o servidor backend, a documentação estará disponível em:

🔗 **http://localhost:8000/api/documentation**

---