-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/06/2025 às 13:21
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `food`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `slug`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Pizza doce', 'pizza-doce', 1, '2025-06-22 17:31:02', '2025-06-22 20:49:12', NULL),
(2, 'Pizza Salgada', 'pizza-salgada', 1, '2025-06-22 21:01:48', '2025-06-23 20:09:52', NULL),
(3, 'Porções', 'porcoes', 1, '2025-06-22 21:04:29', '2025-06-22 21:19:11', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `extras`
--

CREATE TABLE `extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `extras`
--

INSERT INTO `extras` (`id`, `nome`, `slug`, `preco`, `descricao`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(2, 'Shedder', 'shedder', 5.00, 'shedder com bacon', 1, '2025-06-23 14:53:27', '2025-06-23 14:59:16', NULL),
(3, 'calabresa', 'calabresa', 10.00, 'sdfsfsd', 1, '2025-06-23 14:56:25', '2025-06-25 22:34:15', NULL),
(4, 'Bacon', 'bacon', 5.00, 'asdasdasdasdas', 1, '2025-06-23 18:55:57', '2025-06-23 18:55:57', NULL),
(5, 'Cebola', 'cebola', 5.00, 'Camisetas', 1, '2025-06-23 18:56:55', '2025-06-23 18:56:55', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `medidas`
--

CREATE TABLE `medidas` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `medidas`
--

INSERT INTO `medidas` (`id`, `nome`, `descricao`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Pizza P', 'Pizza 4 pedaços', 1, '2025-06-23 18:42:12', '2025-06-23 19:50:11', NULL),
(2, 'Pizza M', 'Pizza 8 predaços', 1, '2025-06-23 18:42:12', '2025-06-23 18:42:12', NULL),
(3, 'GG', 'Pizza', 1, '2025-06-23 19:46:36', '2025-06-23 20:02:16', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-06-16-154557', 'App\\Database\\Migrations\\CriaTabelaUsuarios', 'default', 'App', 1750380401, 1),
(3, '2025-06-22-202157', 'App\\Database\\Migrations\\CriaTabelaCategorias', 'default', 'App', 1750624258, 2),
(4, '2025-06-23-002838', 'App\\Database\\Migrations\\CriaTabelaExtras', 'default', 'App', 1750638806, 3),
(5, '2025-06-23-213608', 'App\\Database\\Migrations\\CriaTabelaMedidas', 'default', 'App', 1750714698, 4),
(6, '2025-06-23-230842', 'App\\Database\\Migrations\\CriaTabelaProdutos', 'default', 'App', 1750720845, 5),
(7, '2025-06-25-225837', 'App\\Database\\Migrations\\CriaTabelaProdutosExtras', 'default', 'App', 1750893245, 6),
(8, '2025-06-26-221800', 'App\\Database\\Migrations\\CriaTabelaProdutoEspecificacoes', 'default', 'App', 1750976708, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(5) UNSIGNED NOT NULL,
  `categoria_id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `ingredientes` text NOT NULL,
  `descricao` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `imagem` varchar(200) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `categoria_id`, `nome`, `slug`, `ingredientes`, `descricao`, `ativo`, `imagem`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 1, 'Pizza doce de brigadeiro', 'pizza-doce-de-brigadeiro', '<p><strong>Farinha</strong><br><span style=\"text-decoration: underline;\"><strong>Ovo</strong></span><br><em><strong>Doce de Leite </strong></em></p>\r\n<p><span style=\"text-decoration: underline;\">Uisuiodus</span></p>', 'aaaaaaaaaaasssssssssss', 1, '', '2025-06-23 20:36:10', '2025-06-25 20:52:25', NULL),
(2, 2, 'Pizza Calabresa 1', 'pizza-calabresa-1', '<p data-start=\"187\" data-end=\"206\"><strong>Calabresa fatiada</strong></p>\r\n<p data-start=\"209\" data-end=\"236\"><em><strong>Molho de tomate artesanal</strong></em></p>\r\n<p data-start=\"239\" data-end=\"257\"><span style=\"text-decoration: underline;\">Queijo mussarela</span></p>\r\n<p data-start=\"260\" data-end=\"284\"><em>Cebola roxa em rodelas</em></p>\r\n<p data-start=\"287\" data-end=\"296\">Or&eacute;gano</p>\r\n<p>Massa fina e crocante</p>', 'A tradicional e irresistível! Uma explosão de sabor com calabresa levemente picante, queijo derretido e a suavidade da cebola, finalizada com um toque especial de orégano. Ideal para quem ama o clássico.', 1, '', '2025-06-24 22:04:52', '2025-06-25 19:56:06', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_especificacoes`
--

CREATE TABLE `produtos_especificacoes` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `medida_id` int(5) UNSIGNED NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `costomizavel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produtos_especificacoes`
--

INSERT INTO `produtos_especificacoes` (`id`, `produto_id`, `medida_id`, `preco`, `costomizavel`) VALUES
(1, 1, 3, 55.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_extras`
--

CREATE TABLE `produtos_extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `extra_id` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produtos_extras`
--

INSERT INTO `produtos_extras` (`id`, `produto_id`, `extra_id`) VALUES
(2, 1, 2),
(6, 2, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `ativacao_hash` varchar(64) DEFAULT NULL,
  `reset_hash` varchar(64) DEFAULT NULL,
  `reset_expira_em` datetime DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `telefone`, `is_admin`, `ativo`, `password_hash`, `ativacao_hash`, `reset_hash`, `reset_expira_em`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Suporte', 'seudeliverytrx@gmail.com', '', '(44) 9724-9833', 1, 1, '$2y$10$Yvxhj2n.BF.eQ8WohuSDyu9xLYwK9is.XdstkMWnNvrWo3gQ13WIO', NULL, NULL, NULL, '2025-06-20 00:53:18', '2025-06-23 18:51:25', NULL),
(2, 'Kaio', 'kaiogremaschidasilva@gmail.com', '368.407.480-22', '(44) 9724-9833', 1, 1, '$2y$10$5roag9kAc8J2MyDJdP7jrOoRgcwIVGXf00l.p2gl55stEbc/euPNK', NULL, NULL, NULL, '2025-06-20 00:53:18', '2025-06-24 13:15:12', NULL),
(5, 'Fabio', 'petitecloe.finenceiro@gmail.com', '440.820.270-33', '(44) 9923-0790', 0, 1, '$2y$10$KJvRujPZYokG93SezRj/neVay7DTr9ma4JllJM5sjwd0H/jGpgWLK', NULL, NULL, NULL, '2025-06-22 00:04:40', '2025-06-22 21:15:23', NULL),
(6, 'Gaby', 'gabrielasouzacaiado@gmail.com', '104.026.419-06', '(44) 98868-9729', 0, 1, '$2y$10$hpj0WYpEAPxeZsUOx4jF8.qRWe1AE4dDnjL6R9WlkwppTb9hnh0Oq', NULL, NULL, NULL, '2025-06-22 17:11:18', '2025-06-23 08:23:21', NULL),
(10, 'Usuario ', 'usuario@gmail.com', '115.439.429-89', '(44) 99724-9833', 1, 1, '$2y$10$gH1dnIFl5stdjLdWhoacr.dJFaxe4w5fbjdcIZoeVxH1RSfNKjRp6', NULL, NULL, NULL, '2025-06-25 21:01:30', '2025-06-25 21:01:30', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `produtos_categoria_id_foreign` (`categoria_id`);

--
-- Índices de tabela `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_especificacoes_produto_id_foreign` (`produto_id`),
  ADD KEY `produtos_especificacoes_medida_id_foreign` (`medida_id`);

--
-- Índices de tabela `produtos_extras`
--
ALTER TABLE `produtos_extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_extras_produto_id_foreign` (`produto_id`),
  ADD KEY `produtos_extras_extra_id_foreign` (`extra_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `ativacao_hash` (`ativacao_hash`),
  ADD UNIQUE KEY `reset_hash` (`reset_hash`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos_extras`
--
ALTER TABLE `produtos_extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Restrições para tabelas `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  ADD CONSTRAINT `produtos_especificacoes_medida_id_foreign` FOREIGN KEY (`medida_id`) REFERENCES `medidas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtos_especificacoes_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `produtos_extras`
--
ALTER TABLE `produtos_extras`
  ADD CONSTRAINT `produtos_extras_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtos_extras_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
