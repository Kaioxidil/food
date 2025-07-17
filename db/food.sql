-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/07/2025 às 02:25
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
-- Estrutura para tabela `bairros`
--

CREATE TABLE `bairros` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `cidade` varchar(128) NOT NULL DEFAULT 'Terra Roxa - PR',
  `slug` varchar(128) NOT NULL,
  `valor_entrega` decimal(10,2) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `bairros`
--

INSERT INTO `bairros` (`id`, `nome`, `cidade`, `slug`, `valor_entrega`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Jardim Veneza', 'Terra Roxa - PR', 'jardim-veneza', 5.00, 1, '2025-07-07 18:54:45', '2025-07-07 18:54:45', NULL);

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
  `deletado_em` datetime DEFAULT NULL,
  `imagem` varchar(240) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `slug`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`, `imagem`) VALUES
(1, 'Pizza doce', 'pizza-doce', 1, '2025-06-22 17:31:02', '2025-07-09 22:10:55', NULL, '1752109855_f7e66c3ba80f74eb9a7e.jpg'),
(2, 'Pizza Salgada', 'pizza-salgada', 1, '2025-06-22 21:01:48', '2025-07-09 22:16:07', NULL, '1752110167_9596d54eccaa51105249.jpg'),
(3, 'Porções', 'porcoes', 1, '2025-06-22 21:04:29', '2025-07-09 22:16:17', NULL, '1752110177_f0c066970646675b672f.jpg'),
(7, 'Entradas', 'entradas', 1, '2025-07-14 19:50:52', '2025-07-14 19:51:21', NULL, '1752533481_20fcf3084fd6eed44be4.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entregadores`
--

CREATE TABLE `entregadores` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `cnh` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(240) NOT NULL,
  `imagem` varchar(240) DEFAULT NULL,
  `veiculo` varchar(240) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `entregadores`
--

INSERT INTO `entregadores` (`id`, `nome`, `cpf`, `cnh`, `email`, `telefone`, `endereco`, `imagem`, `veiculo`, `placa`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Kaio Gremaschi da Silva', '115.439.429-89', '11526591889', 'kaiogremaschidasilva@gmail.com', '(44) 99724-9833', 'Rua Simão Rodrigues Da Silva', '1752014874_de7e21fe6845421bffa8.png', 'Biz 125', 'JPP-1785', 1, '2025-07-08 19:40:02', '2025-07-08 19:47:55', NULL);

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
-- Estrutura para tabela `formas_pagamento`
--

CREATE TABLE `formas_pagamento` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `formas_pagamento`
--

INSERT INTO `formas_pagamento` (`id`, `nome`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Dinheiro', 1, '2025-06-30 19:00:54', '2025-06-30 19:00:54', NULL),
(2, 'Cartão de crédito', 1, '2025-07-01 19:37:00', '2025-07-01 20:20:53', NULL),
(3, 'Cartão de débito', 1, '2025-07-01 20:03:42', '2025-07-01 20:03:42', NULL);

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
(9, '2025-06-26-221800', 'App\\Database\\Migrations\\CriaTabelaProdutoEspecificacoes', 'default', 'App', 1751233138, 7),
(10, '2025-06-30-154807', 'App\\Database\\Migrations\\CriaTabelaFormasPagamento', 'default', 'App', 1751298643, 8),
(11, '2025-07-03-230235', 'App\\Database\\Migrations\\CriaTabelaEsntregadores', 'default', 'App', 1751584292, 9),
(12, '2025-07-07-155506', 'App\\Database\\Migrations\\Bairro', 'default', 'App', 1751904239, 10),
(13, '2025-07-11-015103', 'App\\Database\\Migrations\\AddRestauranteSlugToProdutos', 'default', 'App', 1752198705, 11),
(14, '2025-07-16-154303', 'App\\Database\\Migrations\\CriaTabelaPedidos', 'default', 'App', 1752680600, 12),
(15, '2025-07-16-232746', 'App\\Database\\Migrations\\CreateUsuariosEnderecos', 'default', 'App', 1752708482, 13),
(16, '2025-07-17-000115', 'App\\Database\\Migrations\\AddObservacaoToPedidosItens', 'default', 'App', 1752710497, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(5) UNSIGNED NOT NULL,
  `usuario_id` int(5) UNSIGNED DEFAULT NULL,
  `forma_pagamento_id` int(5) UNSIGNED NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `forma_pagamento_id`, `valor_total`, `status`, `observacoes`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 13, 1, 0.00, 'pendente', NULL, '2025-07-16 12:52:00', NULL, NULL),
(2, 1, 1, 0.00, 'pendente', 'tes tes teste teste', '2025-07-16 13:31:46', NULL, NULL),
(3, 1, 1, 0.00, 'pendente', '', '2025-07-16 18:14:35', NULL, NULL),
(4, 1, 1, 0.00, 'pendente', '', '2025-07-16 18:56:14', NULL, NULL),
(8, 1, 1, 70.00, 'pendente', '100', '2025-07-16 21:14:49', NULL, NULL),
(9, 1, 1, 60.00, 'pendente', '100', '2025-07-16 21:20:37', NULL, NULL),
(10, 1, 2, 70.00, 'pendente', '', '2025-07-16 21:24:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos_itens`
--

CREATE TABLE `pedidos_itens` (
  `id` int(5) UNSIGNED NOT NULL,
  `pedido_id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `especificacao_id` int(5) UNSIGNED DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `observacao` text DEFAULT NULL,
  `preco_extras` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `pedidos_itens`
--

INSERT INTO `pedidos_itens` (`id`, `pedido_id`, `produto_id`, `especificacao_id`, `quantidade`, `preco_unitario`, `observacao`, `preco_extras`, `subtotal`) VALUES
(1, 1, 5, NULL, 1, 0.00, NULL, 0.00, 0.00),
(2, 2, 6, NULL, 1, 0.00, NULL, 0.00, 0.00),
(3, 3, 1, NULL, 1, 0.00, NULL, 0.00, 0.00),
(4, 4, 7, NULL, 2, 0.00, NULL, 0.00, 0.00),
(5, 4, 7, NULL, 3, 0.00, NULL, 0.00, 0.00),
(9, 8, 7, 9, 1, 65.00, NULL, 0.00, 0.00),
(10, 9, 1, 1, 1, 55.00, NULL, 0.00, 0.00),
(11, 10, 7, 9, 1, 65.00, NULL, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos_itens_extras`
--

CREATE TABLE `pedidos_itens_extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `pedido_item_id` int(5) UNSIGNED NOT NULL,
  `extra_id` int(5) UNSIGNED NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `pedidos_itens_extras`
--

INSERT INTO `pedidos_itens_extras` (`id`, `pedido_item_id`, `extra_id`, `quantidade`, `preco`) VALUES
(7, 9, 3, 1, 10.00),
(8, 9, 4, 1, 5.00),
(9, 11, 3, 1, 10.00),
(10, 11, 4, 1, 5.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(5) UNSIGNED NOT NULL,
  `categoria_id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `restaurante_slug` varchar(255) NOT NULL,
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

INSERT INTO `produtos` (`id`, `categoria_id`, `nome`, `restaurante_slug`, `slug`, `ingredientes`, `descricao`, `ativo`, `imagem`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 1, 'Pizza doce de brigadeiro', '', 'pizza-doce-de-brigadeiro', '<p><strong>Farinha</strong><br><span style=\"text-decoration: underline;\"><strong>Ovo</strong></span><br><em><strong>Doce de Leite </strong></em></p>\r\n<p><span style=\"text-decoration: underline;\">Uisuiodus</span></p>', 'aaaaaaaaaaasssssssssss', 1, '1752113046_711209e81a8e6acb598e.jpg', '2025-06-23 20:36:10', '2025-07-09 23:04:06', NULL),
(2, 2, 'Pizza Calabresa', '', 'pizza-calabresa', '<p data-start=\"187\" data-end=\"206\"><strong>Calabresa fatiada</strong></p>\r\n<p data-start=\"209\" data-end=\"236\"><em><strong>Molho de tomate artesanal</strong></em></p>\r\n<p data-start=\"239\" data-end=\"257\"><span style=\"text-decoration: underline;\">Queijo mussarela</span></p>\r\n<p data-start=\"260\" data-end=\"284\"><em>Cebola roxa em rodelas</em></p>\r\n<p data-start=\"287\" data-end=\"296\">Or&eacute;gano</p>\r\n<p>Massa fina e crocante</p>', 'A tradicional e irresistível! Uma explosão de sabor com calabresa levemente picante, queijo derretido e a suavidade da cebola, finalizada com um toque especial de orégano. Ideal para quem ama o clássico.', 1, '1752114101_66a8aca884c20f48e21e.jpg', '2025-06-24 22:04:52', '2025-07-09 23:21:41', NULL),
(5, 3, 'Porção de tilapias', '', 'porcao-de-tilapias', '<p><strong>500g de Tilapia</strong></p>', 'Porçao de tilapias finas com molho verde', 1, '1751331250_cc6af003863d53b0d285.jpg', '2025-06-30 21:53:34', '2025-06-30 21:54:11', NULL),
(6, 2, 'Moda da Casa', '', 'moda-da-casa', '<p><strong>Ovo</strong></p>', 'Moda da Casa', 1, '1752114263_68420d7d01cc8ce8e8dc.jpg', '2025-07-09 23:23:56', '2025-07-09 23:24:23', NULL),
(7, 7, 'Entrada Especial', '', 'entrada-especial', '<ul>\r\n<li>dasdas</li>\r\n<li>dasda</li>\r\n<li>dasda</li>\r\n<li>dasdas</li>\r\n<li>dasdas</li>\r\n</ul>', 'Tal ', 1, '1752533557_4aef01ac45b9b14cb88a.jpg', '2025-07-14 19:52:17', '2025-07-14 19:52:38', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_especificacoes`
--

CREATE TABLE `produtos_especificacoes` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `medida_id` int(5) UNSIGNED NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `customizavel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produtos_especificacoes`
--

INSERT INTO `produtos_especificacoes` (`id`, `produto_id`, `medida_id`, `preco`, `customizavel`) VALUES
(1, 1, 1, 55.00, 1),
(2, 1, 2, 10.00, 1),
(5, 2, 1, 15.00, 1),
(6, 2, 2, 25.00, 1),
(7, 5, 3, 35.00, 0),
(8, 6, 3, 55.00, 0),
(9, 7, 1, 50.00, 1),
(10, 7, 2, 55.00, 0);

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
(6, 2, 3),
(7, 1, 3),
(8, 6, 3),
(9, 7, 3),
(10, 7, 4);

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
(13, 'Html', 'htmlnapratica@gmail.com', '035.124.790-49', '(44) 99724-9833', 0, 1, '$2y$10$8jgCFM8vm69tlkBji9HD6.IMjJJAYcb8.sHCBQDwDO2W5gs1EWdKK', NULL, NULL, NULL, '2025-07-15 13:14:17', '2025-07-15 13:14:17', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_enderecos`
--

CREATE TABLE `usuarios_enderecos` (
  `id` int(5) UNSIGNED NOT NULL,
  `usuario_id` int(5) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios_enderecos`
--

INSERT INTO `usuarios_enderecos` (`id`, `usuario_id`, `titulo`, `cep`, `logradouro`, `numero`, `bairro`, `cidade`, `estado`, `complemento`, `referencia`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 1, 'Casa', '85990000', 'Simão Rodrigues da SIlva', '134', 'JARDIM VENEZA', 'Terra Roxa', 'PR', '', '', '2025-07-16 20:43:28', '2025-07-16 20:43:28', NULL),
(2, 1, 'Trabalho', '85990000', 'Rua Sao paulo', '171', 'CENTRO', 'Terra Roxa', 'PR', '', '', '2025-07-16 20:55:18', '2025-07-16 20:55:18', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `bairros`
--
ALTER TABLE `bairros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `entregadores`
--
ALTER TABLE `entregadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `cnh` (`cnh`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefone` (`telefone`);

--
-- Índices de tabela `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
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
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_usuario_id_foreign` (`usuario_id`),
  ADD KEY `pedidos_forma_pagamento_id_foreign` (`forma_pagamento_id`);

--
-- Índices de tabela `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_itens_pedido_id_foreign` (`pedido_id`),
  ADD KEY `pedidos_itens_produto_id_foreign` (`produto_id`),
  ADD KEY `pedidos_itens_especificacao_id_foreign` (`especificacao_id`);

--
-- Índices de tabela `pedidos_itens_extras`
--
ALTER TABLE `pedidos_itens_extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_itens_extras_pedido_item_id_foreign` (`pedido_item_id`),
  ADD KEY `pedidos_itens_extras_extra_id_foreign` (`extra_id`);

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
-- Índices de tabela `usuarios_enderecos`
--
ALTER TABLE `usuarios_enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_enderecos_usuario_id_foreign` (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bairros`
--
ALTER TABLE `bairros`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `entregadores`
--
ALTER TABLE `entregadores`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `pedidos_itens_extras`
--
ALTER TABLE `pedidos_itens_extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `produtos_extras`
--
ALTER TABLE `produtos_extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuarios_enderecos`
--
ALTER TABLE `usuarios_enderecos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_forma_pagamento_id_foreign` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `formas_pagamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Restrições para tabelas `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  ADD CONSTRAINT `pedidos_itens_especificacao_id_foreign` FOREIGN KEY (`especificacao_id`) REFERENCES `produtos_especificacoes` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `pedidos_itens_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_itens_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedidos_itens_extras`
--
ALTER TABLE `pedidos_itens_extras`
  ADD CONSTRAINT `pedidos_itens_extras_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_itens_extras_pedido_item_id_foreign` FOREIGN KEY (`pedido_item_id`) REFERENCES `pedidos_itens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Restrições para tabelas `usuarios_enderecos`
--
ALTER TABLE `usuarios_enderecos`
  ADD CONSTRAINT `usuarios_enderecos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
