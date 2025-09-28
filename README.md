# Atividade_PHP
Projeto Oficina de Artes - Site em PHP

Aplicação em PHP + HTML para uma oficina de artes, com CRUD e galeria de imagens.

Funcionalidades

Home: mostra último registro de Sobre a Oficina.

Sobre: CRUD com upload de imagem.

Galeria: exibe imagens em miniatura.

Contato: página estrutural.

Includes: header.php (menu) e footer.php (créditos).

Tecnologias

PHP 8.x · MySQL · PDO · HTML puro

Banco de Dados
CREATE DATABASE oficina_db;
CREATE TABLE sobre (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT NOT NULL,
  foto_path VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Como rodar

Clonar repositório

Criar banco (script ou /db.sql)

Configurar db.php

Acessar: http://localhost:8000

Observações

Upload aceita: jpg, jpeg, png, gif, webp

Sem CSS propositalmente (estilização futura)
