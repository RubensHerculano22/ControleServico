-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30-Jun-2021 às 22:30
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aviseme`
--

CREATE TABLE `aviseme` (
  `id` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `avisado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `id_pai` int(11) NOT NULL,
  `icon` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `color1` varchar(20) DEFAULT NULL,
  `color2` varchar(20) DEFAULT NULL,
  `color3` varchar(20) DEFAULT NULL,
  `color4` varchar(20) DEFAULT NULL,
  `color5` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contrataservico`
--

CREATE TABLE `contrataservico` (
  `id` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_servico` date DEFAULT NULL,
  `hora_servico` varchar(20) DEFAULT NULL,
  `descricao` varchar(1500) DEFAULT NULL,
  `endereco` varchar(300) DEFAULT NULL,
  `orcamento` varchar(20) DEFAULT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `controlevisualizacao`
--

CREATE TABLE `controlevisualizacao` (
  `id` int(11) NOT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_acesso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `numero` int(11) NOT NULL,
  `cidade` varchar(150) NOT NULL,
  `estado` int(11) NOT NULL,
  `complemento` varchar(150) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `esquecisenha`
--

CREATE TABLE `esquecisenha` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  `codigo` varchar(20) NOT NULL,
  `data_solicitacao` datetime DEFAULT NULL,
  `data_troca` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sigla` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `data_inclusao` datetime NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `quantidade_estrelas` int(11) NOT NULL,
  `titulo` int(11) NOT NULL,
  `descricao` blob,
  `data_inclusao` datetime DEFAULT NULL,
  `id_orcamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `titulo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarioservico`
--

CREATE TABLE `horarioservico` (
  `id` int(11) NOT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `texto` varchar(40) DEFAULT NULL,
  `dia_semana` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

CREATE TABLE `imagens` (
  `id` int(11) NOT NULL,
  `img` blob,
  `ativo` tinyint(4) NOT NULL,
  `principal` tinyint(4) NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `tipo_imagem` varchar(45) DEFAULT NULL,
  `data_insercao` datetime DEFAULT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `listahorario`
--

CREATE TABLE `listahorario` (
  `id` int(11) NOT NULL,
  `horario` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `id` int(11) NOT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamentostatus`
--

CREATE TABLE `orcamentostatus` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentoservico`
--

CREATE TABLE `pagamentoservico` (
  `id` int(11) NOT NULL,
  `id_tipo_pagamento` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `vezes` int(11) DEFAULT NULL,
  `juros` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `pergunta` varchar(1200) NOT NULL,
  `resposta` varchar(1200) DEFAULT NULL,
  `data_inclusao` datetime NOT NULL,
  `data_resposta` datetime DEFAULT NULL,
  `id_servico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `descricao_curta` varchar(610) DEFAULT NULL,
  `descricao` blob,
  `data_inclusao` datetime NOT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `id_tipo_servico` tinyint(4) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `valor` float DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `cidade` int(11) DEFAULT NULL,
  `bairro` varchar(150) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(150) DEFAULT NULL,
  `quantidade_disponivel` int(11) DEFAULT NULL,
  `caucao` float DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipopagamento`
--

CREATE TABLE `tipopagamento` (
  `id` int(11) NOT NULL,
  `nome` varchar(75) NOT NULL,
  `forma_pagamento` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tiposervico`
--

CREATE TABLE `tiposervico` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `sobrenome` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(10) DEFAULT NULL,
  `celular` varchar(11) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `bairro` varchar(150) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(150) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `complemento` varchar(150) DEFAULT NULL,
  `email` varchar(180) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `data_insercao` date DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `ativar_conta` int(11) DEFAULT '0',
  `data_ativacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aviseme`
--
ALTER TABLE `aviseme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contrataservico`
--
ALTER TABLE `contrataservico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `controlevisualizacao`
--
ALTER TABLE `controlevisualizacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `esquecisenha`
--
ALTER TABLE `esquecisenha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horarioservico`
--
ALTER TABLE `horarioservico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listahorario`
--
ALTER TABLE `listahorario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orcamentostatus`
--
ALTER TABLE `orcamentostatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagamentoservico`
--
ALTER TABLE `pagamentoservico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipopagamento`
--
ALTER TABLE `tipopagamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tiposervico`
--
ALTER TABLE `tiposervico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aviseme`
--
ALTER TABLE `aviseme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
