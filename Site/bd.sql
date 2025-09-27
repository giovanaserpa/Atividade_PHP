CREATE DATABASE IF NOT EXISTS oficina_db;
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE oficina_db;

CREATE TABLE IF NOT EXISTS `tb_sobre` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `foto_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
