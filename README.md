
# ✅To-do
Aplicação simples de gerenciamento de atividades que se conecta com um banco de dados

## 🎯 Objetivo
Desenvolver uma aplicação de gerenciamento de tarefas (To Do)
#### 📋 Requisitos funcionais do projeto
- CRUD de Tarefa
- CRUD de Tag
- Listar todas as tarefas
- Listar tarefas por Tag

## 🛠️ Construído com
- PHP e Apache
- HTML e CSS para interface gráfica
- SQL (Postgres)

## 🖇️ Referências
- Como Criar um [ambiente docker para php e postgres](https://dev.to/brayanmonteiroo/como-criar-um-ambiente-docker-com-php-apache-postgresql-e-pgadmin-39ep)
- Pesquisa com [Deepseek](https://chat.deepseek.com/)
- Layout da interface []()

## 🔧 Instalação
- Primeiramente o [Docker](https://www.docker.com/) precisa está instalado na sua máquina
- Ao clonar o projeto, abra o terminal na pasta e execute:
  1. ``` docker-compose build ``` para instalar as imagens 
  2. ``` docker-compose up ``` para iniciar o servidor
- Acesse pelo seu navegador [http://localhost]()


## 🎨 Criação das tabelas pelo docker
Para acessar o container do bando de dados:
```bash
docker exec -it <db_container_id> bash
```
Dentro do container, acessar o nome do banco definido no docker-compose:
```bash
psql -U <db_user> -d todo_database_aplication
```
Executar os comandos que eu preciso?
```bash
todo_database_aplication=# CREATE TABLE tag(
       id SERIAL PRIMARY KEY,
       titulo VARCHAR(255) NOT NULL
);
todo_database_aplication=# CREATE TABLE tarefa(
      id SERIAL PRIMARY KEY,
      titulo VARCHAR(255) NOT NULL,
      data_criado TIMESTAMP,
      data_final TIMESTAMP,
      entrege BOOLEAN DEFAULT FALSE,
      tag INT,
      CONSTRAINT fk_tarefa_tag FOREIGN KEY (tag) REFERENCES tag(id)
);

todo_database_aplication=# \dt 
      List of relations
      Schema |  Name  | Type  | Owner
      --------+--------+-------+-------
      public | tag    | table | username
      public | tarefa | table | username
```
