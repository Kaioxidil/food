-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/07/2025 às 05:16
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
(1, 'Jardim Veneza', 'Terra Roxa - PR', 'jardim-veneza', 5.00, 1, '2025-07-17 12:44:56', '2025-07-19 19:21:54', NULL),
(2, 'Centro', 'Terra Roxa - PR', 'centro', 5.00, 1, NULL, NULL, NULL),
(3, 'Jardim Paraíso', 'Terra Roxa - PR', 'jardim-paraiso', 5.00, 1, NULL, NULL, NULL),
(4, 'Vila Nova', 'Terra Roxa - PR', 'vila-nova', 5.00, 1, NULL, NULL, NULL),
(5, 'Jardim das Acácias', 'Terra Roxa - PR', 'jardim-das-acacias', 5.00, 1, NULL, NULL, NULL),
(6, 'Vila São João', 'Terra Roxa - PR', 'vila-sao-joao', 5.00, 1, NULL, NULL, NULL),
(7, 'Parque Industrial', 'Terra Roxa - PR', 'parque-industrial', 5.00, 1, NULL, NULL, NULL),
(8, 'Jardim Primavera', 'Terra Roxa - PR', 'jardim-primavera', 5.00, 1, NULL, NULL, NULL),
(9, 'Vila Mariana', 'Terra Roxa - PR', 'vila-mariana', 5.00, 1, NULL, NULL, NULL),
(10, 'Jardim das Flores', 'Terra Roxa - PR', 'jardim-das-flores', 5.00, 1, NULL, NULL, NULL),
(11, 'Vila Industrial', 'Terra Roxa - PR', 'vila-industrial', 5.00, 1, NULL, NULL, NULL),
(12, 'Jardim Europa', 'Terra Roxa - PR', 'jardim-europa', 5.00, 1, '2025-07-17 21:53:37', '2025-07-17 21:53:37', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `imagem` varchar(240) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `slug`, `ativo`, `imagem`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Porções', 'porcoes', 1, '1752766317_6b6255698f7925ff7740.jpg', '2025-07-17 00:23:33', '2025-07-17 12:31:57', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) UNSIGNED NOT NULL,
  `nome` varchar(120) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `logradouro` varchar(100) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(60) NOT NULL,
  `cidade` varchar(60) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `maps_iframe` text DEFAULT NULL COMMENT 'Código do iframe de localização no Google Maps',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(1, 'Lipao', '338.222.230-26', '17000663361', 'kaiogremaschidasilva@gmail.com', '(44) 99724-9833', 'Rua Simão Rodrigues Da Silva', NULL, 'Fan 125', 'KLD-3514', 1, '2025-07-18 20:52:44', '2025-07-18 20:52:44', NULL);

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
(1, 'Calabresa', 'calabresa', 0.00, 'Calabresa Seara', 1, '2025-07-17 00:22:25', '2025-07-17 00:22:25', NULL);

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
(1, 'Dinheiro', 1, '2025-07-16 22:00:37', '2025-07-16 22:00:37', NULL);

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
(1, 'Porção P', '', 1, '2025-07-17 00:23:02', '2025-07-17 00:23:02', NULL),
(2, 'Porção M', '', 1, '2025-07-19 19:17:41', '2025-07-19 19:17:41', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-06-16-154557', 'App\\Database\\Migrations\\CriaTabelaUsuarios', 'default', 'App', 1752713953, 1),
(2, '2025-06-22-202157', 'App\\Database\\Migrations\\CriaTabelaCategorias', 'default', 'App', 1752713953, 1),
(3, '2025-06-23-002838', 'App\\Database\\Migrations\\CriaTabelaExtras', 'default', 'App', 1752713954, 1),
(4, '2025-06-23-213608', 'App\\Database\\Migrations\\CriaTabelaMedidas', 'default', 'App', 1752713954, 1),
(5, '2025-06-23-230842', 'App\\Database\\Migrations\\CriaTabelaProdutos', 'default', 'App', 1752713954, 1),
(6, '2025-06-25-225837', 'App\\Database\\Migrations\\CriaTabelaProdutosExtras', 'default', 'App', 1752713954, 1),
(7, '2025-06-26-221800', 'App\\Database\\Migrations\\CriaTabelaProdutoEspecificacoes', 'default', 'App', 1752713954, 1),
(8, '2025-06-30-154807', 'App\\Database\\Migrations\\CriaTabelaFormasPagamento', 'default', 'App', 1752713954, 1),
(9, '2025-07-03-230235', 'App\\Database\\Migrations\\CriaTabelaEsntregadores', 'default', 'App', 1752713954, 1),
(10, '2025-07-07-155506', 'App\\Database\\Migrations\\Bairro', 'default', 'App', 1752713954, 1),
(11, '2025-07-11-015103', 'App\\Database\\Migrations\\AddRestauranteSlugToProdutos', 'default', 'App', 1752713954, 1),
(12, '2025-07-16-154303', 'App\\Database\\Migrations\\CriaTabelaPedidos', 'default', 'App', 1752713954, 1),
(13, '2025-07-16-232746', 'App\\Database\\Migrations\\CreateUsuariosEnderecos', 'default', 'App', 1752713954, 1),
(14, '2025-07-17-000115', 'App\\Database\\Migrations\\AddObservacaoToPedidosItens', 'default', 'App', 1752713954, 1),
(15, '2025-07-18-234125', 'App\\Database\\Migrations\\AddEntregadorIdToPedidos', 'default', 'App', 1752882117, 2),
(16, '2025-07-18-234858', 'App\\Database\\Migrations\\AddEnderecoIdToPedidos', 'default', 'App', 1752882552, 3),
(17, '2025-07-19-015722', 'App\\Database\\Migrations\\CriaTabelaEmpresas', 'default', 'App', 1752890264, 4),
(18, '2025-07-19-015845', 'App\\Database\\Migrations\\RenomeiaEmpresa', 'default', 'App', 1752890329, 5),
(19, '2025-07-19-015845', 'App\\Database\\Migrations\\RenomeiaEmpresasParaEmpresa', 'default', 'App', 1752890349, 6),
(20, '2025-07-19-020108', 'App\\Database\\Migrations\\AdicionaCampoMapsIframeEmpresa', 'default', 'App', 1752890557, 7),
(21, '2025-07-21-224856', 'App\\Database\\Migrations\\AdicionaValorEntregaEmPedidos', 'default', 'App', 1753138161, 8),
(22, '2025-07-22-021047', 'App\\Database\\Migrations\\AddFotoPerfilToUsuarios', 'default', 'App', 1753150277, 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(5) UNSIGNED NOT NULL,
  `usuario_id` int(5) UNSIGNED DEFAULT NULL,
  `entregador_id` int(11) DEFAULT NULL,
  `endereco_id` int(11) DEFAULT NULL,
  `forma_pagamento_id` int(5) UNSIGNED NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,
  `valor_entrega` decimal(10,2) NOT NULL DEFAULT 0.00,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `entregador_id`, `endereco_id`, `forma_pagamento_id`, `valor_total`, `status`, `observacoes`, `valor_entrega`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(15, 1, 1, 1, 1, 30.00, 'entregue', '50', 5.00, '2025-07-21 19:54:02', '2025-07-21 22:51:09', NULL),
(16, 1, 1, 1, 1, 35.00, 'saiu_para_entrega', '50', 5.00, '2025-07-21 20:00:06', '2025-07-21 22:13:35', NULL),
(17, 1, 1, 1, 1, 30.00, 'entregue', '', 5.00, '2025-07-21 20:40:01', '2025-07-21 22:52:00', NULL);

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
(15, 16, 1, 2, 1, 30.00, NULL, 0.00, 30.00),
(16, 17, 1, 1, 1, 25.00, NULL, 0.00, 25.00);

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
(1, 1, 'Porção de tilapia', '', 'porcao-de-tilapia', '<p>500g de Tilapia</p>\r\n<p>Alface</p>', '500g de Tilapia', 1, '1752722730_e3cd8eba885c0968fafe.jpg', '2025-07-17 00:25:24', '2025-07-17 00:25:30', NULL);

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
(1, 1, 1, 25.00, 0),
(2, 1, 2, 30.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_extras`
--

CREATE TABLE `produtos_extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `extra_id` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `foto_perfil` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `ativacao_hash` varchar(64) DEFAULT NULL,
  `reset_hash` varchar(64) DEFAULT NULL,
  `reset_expira_em` datetime DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `telefone`, `foto_perfil`, `is_admin`, `ativo`, `password_hash`, `ativacao_hash`, `reset_hash`, `reset_expira_em`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Suporte', 'seudeliverytrx@gmail.com', '115.439.429-89', '(44) 99724-9833', NULL, 1, 1, '$2y$10$DKe9ECmIuEjxILIP6wRxX.4Ph1bsWGhoMykYxkaU4Tm1ReeyW/do2', NULL, NULL, NULL, '2025-07-16 22:08:07', '2025-07-22 00:11:59', NULL);

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
(1, 1, 'Casa', '85990000', 'Simão Rodrigues da SIlva', '134', '1', 'Terra Roxa', 'PR', '', '', '2025-07-19 01:49:25', '2025-07-19 01:49:25', NULL);

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
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

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
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `entregadores`
--
ALTER TABLE `entregadores`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `pedidos_itens_extras`
--
ALTER TABLE `pedidos_itens_extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `produtos_extras`
--
ALTER TABLE `produtos_extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios_enderecos`
--
ALTER TABLE `usuarios_enderecos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
