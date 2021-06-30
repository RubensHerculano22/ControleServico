-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30-Jun-2021 às 20:45
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

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `id_pai`, `icon`) VALUES
(1, 'Eventos', 0, NULL),
(2, 'Local para eventos', 17, NULL),
(3, 'Assessor de Eventos', 17, NULL),
(4, 'Bartenders', 18, NULL),
(5, 'Carros de Casamento', 17, NULL),
(6, 'Celebrantes', 17, NULL),
(7, 'Buffet Completo', 18, NULL),
(8, 'Confeitaria', 18, NULL),
(9, 'Impressão de Convites', 20, NULL),
(10, 'DJs', 19, NULL),
(11, 'Equipamentos para festas', 17, NULL),
(12, 'Brindes', 20, NULL),
(13, 'Fotografo', 17, NULL),
(14, 'Garçons e Copeiras', 17, NULL),
(15, 'Recepcionistas e Cerimonialistas', 17, NULL),
(16, 'Segurança', 17, NULL),
(17, 'Equipe e Suporte', 1, '<i class=\"fas fa-people-carry\" style=\'color: #54828C\'></i>'),
(18, 'Comes e Bebes', 1, '<i class=\"fas fa-cocktail\" style=\'color: #54828C\'></i>'),
(19, 'Música e Animação', 1, '<i class=\"fab fa-deezer\" style=\'color: #54828C\'></i>'),
(20, 'Serviços complementares', 1, '<i class=\"fas fa-plus-square\" style=\'color: #54828C\'></i>'),
(21, 'Animadores de Festa', 19, NULL),
(22, 'Bandas e Cantores', 19, NULL),
(23, 'Moda e Beleza', 0, NULL),
(24, 'Beleza e Estética', 23, '<i class=\"fas fa-cut\" style=\'color: #54828C\'></i>'),
(25, 'Roupas e Decorações', 23, '<i class=\"fas fa-vest-patches\" style=\'color: #54828C\'></i>'),
(26, 'Depilação', 24, NULL),
(27, 'Design de Sobrancelhas', 24, NULL),
(28, 'Design Cílios', 24, NULL),
(29, 'Manicure e Pedicure', 24, NULL),
(30, 'Maquiadores', 24, NULL),
(31, 'Cabelereiros', 24, NULL),
(32, 'Barberios', 24, NULL),
(33, 'Alfaite', 25, NULL),
(34, 'Corte e Costura', 25, NULL),
(35, 'Artesanatos', 25, NULL),
(36, 'Serviços Domésticos', 0, NULL),
(37, 'Casa', 36, '<i class=\"fas fa-home\" style=\'color: #54828C\'></i>'),
(38, 'Diarista', 37, NULL),
(39, 'Babá', 37, NULL),
(40, 'Cozinheiro(a)', 37, NULL),
(41, 'Motorista', 37, NULL),
(42, 'Reformas', 0, NULL),
(43, 'Construção', 42, '<i class=\"fas fa-hammer\" style=\'color: #54828C\'></i>'),
(44, 'Instalações', 42, '<i class=\"fas fa-screwdriver\" style=\'color: #54828C\'></i>'),
(45, 'Reparos', 42, '<i class=\"fas fa-wrench\" style=\'color: #54828C\'></i>'),
(46, 'Serviços Gerais', 42, '<i class=\"fab fa-whmcs\" style=\'color: #54828C\'></i>'),
(47, 'Pedreiro', 43, NULL),
(48, 'Arquitetos', 43, NULL),
(49, 'Design de Interiores', 43, NULL),
(50, 'Portões', 44, NULL),
(51, 'Antenas', 44, NULL),
(52, 'Instalação de Segurança', 44, NULL),
(53, 'Redes de Proteção', 44, NULL),
(54, 'Encanador', 45, NULL),
(55, 'Pintor', 45, NULL),
(56, 'Eletricista', 45, NULL),
(57, 'Vidraceiro', 45, NULL),
(58, 'Chaveiro', 46, NULL),
(59, 'Dedetizador', 46, NULL),
(60, 'Desentupidor', 46, NULL),
(61, 'Mudança', 46, NULL),
(62, 'Montador de Móveis', 46, NULL),
(63, 'Jardinagem', 46, NULL),
(64, 'Piscinas', 46, NULL),
(65, 'Assistência Técnica', 0, NULL),
(66, 'Aparelhos Eletrônicos', 65, '<i class=\"fas fa-tv\" style=\'color: #54828C\'></i>'),
(67, 'Eletrodomésticos', 65, '<i class=\"fas fa-blender\" style=\'color: #54828C\'></i>'),
(68, 'Informática e Telefonia', 65, '<i class=\"fas fa-tablet-alt\" style=\'color: #54828C\'></i>'),
(69, 'Video Game', 66, NULL),
(70, 'Televisão', 66, NULL),
(71, 'Ar Condicionado', 66, NULL),
(72, 'Máquina de Lavar', 67, NULL),
(73, 'Geladeira e Freezer', 67, NULL),
(74, 'Máquina de Costura', 67, NULL),
(75, 'Redes', 68, NULL),
(76, 'Celular', 68, NULL),
(77, 'Computadores', 68, NULL),
(78, 'Telefones Fixos', 68, NULL),
(79, 'Impressora', 68, NULL),
(80, 'Design Geral', 0, NULL),
(81, 'Gráfico', 80, '<i class=\"fas fa-pen\" style=\'color: #54828C\'></i>'),
(82, 'Visual', 80, '<i class=\"fas fa-fill\" style=\'color: #54828C\'></i>'),
(83, 'Criação de logos', 81, NULL),
(84, 'Criação de marcas', 81, NULL),
(85, 'Produção Gráfica', 81, NULL),
(86, 'Modelagem 2D e 3D', 82, NULL),
(87, 'Edição de Fotos', 82, NULL),
(88, 'Ilustração', 82, NULL),
(89, 'Web Design', 82, NULL);

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

--
-- Extraindo dados da tabela `colores`
--

INSERT INTO `colores` (`id`, `color1`, `color2`, `color3`, `color4`, `color5`) VALUES
(1, '#091B26', '#254B59', '#54828C', '#C9EEF2', '#F0F2F0');

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

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`id`, `nome`, `sigla`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amazonas', 'AM'),
(4, 'Amapá', 'AP'),
(5, 'Bahia', 'BA'),
(6, 'Ceará', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espírito Santo', 'ES'),
(9, 'Goiás', 'GO'),
(10, 'Maranhão', 'MA'),
(11, 'Minas Gerais', 'MG'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Mato Grosso', 'MT'),
(14, 'Pará', 'PA'),
(15, 'Paraíba', 'PB'),
(16, 'Pernambuco', 'PE'),
(17, 'Piauí', 'PI'),
(18, 'Paraná', 'PR'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'Rio Grande do Norte', 'RN'),
(21, 'Rondônia', 'RO'),
(22, 'Roraima', 'RR'),
(23, 'Rio Grande do Sul', 'RS'),
(24, 'Santa Catarina', 'SC'),
(25, 'Sergipe', 'SE'),
(26, 'São Paulo', 'SP'),
(27, 'Tocantins', 'TO');

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

--
-- Extraindo dados da tabela `horario`
--

INSERT INTO `horario` (`id`, `titulo`) VALUES
(1, 'Domingo'),
(2, 'Segunda-Feira'),
(3, 'Terça-Feira'),
(4, 'Quarta-Feira'),
(5, 'Quinta-Feira'),
(6, 'Sexta-Feira'),
(7, 'Sábado');

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

--
-- Extraindo dados da tabela `listahorario`
--

INSERT INTO `listahorario` (`id`, `horario`) VALUES
(1, '00:00'),
(2, '00:15'),
(3, '00:30'),
(4, '00:45'),
(5, '01:00'),
(6, '01:15'),
(7, '01:30'),
(8, '01:45'),
(9, '02:00'),
(10, '02:15'),
(11, '02:30'),
(12, '02:45'),
(13, '03:00'),
(14, '03:15'),
(15, '03:30'),
(16, '03:45'),
(17, '04:00'),
(18, '04:15'),
(19, '04:30'),
(20, '04:45'),
(21, '05:00'),
(22, '05:15'),
(23, '05:30'),
(24, '05:45'),
(25, '06:00'),
(26, '06:15'),
(27, '06:30'),
(28, '06:45'),
(29, '07:00'),
(30, '07:15'),
(31, '07:30'),
(32, '07:45'),
(33, '08:00'),
(34, '08:15'),
(35, '08:30'),
(36, '08:45'),
(37, '09:00'),
(38, '09:15'),
(39, '09:30'),
(40, '09:45'),
(41, '10:00'),
(42, '10:15'),
(43, '10:30'),
(44, '10:45'),
(45, '11:00'),
(46, '11:15'),
(47, '11:30'),
(48, '11:45'),
(49, '12:00'),
(50, '12:15'),
(51, '12:30'),
(52, '12:45'),
(53, '13:00'),
(54, '13:15'),
(55, '13:30'),
(56, '13:45'),
(57, '14:00'),
(58, '14:15'),
(59, '14:30'),
(60, '14:45'),
(61, '15:00'),
(62, '15:15'),
(63, '15:30'),
(64, '15:45'),
(65, '16:00'),
(66, '16:15'),
(67, '16:30'),
(68, '16:45'),
(69, '17:00'),
(70, '17:15'),
(71, '17:30'),
(72, '17:45'),
(73, '18:00'),
(74, '18:15'),
(75, '18:30'),
(76, '18:45'),
(77, '19:00'),
(78, '19:15'),
(79, '19:30'),
(80, '19:45'),
(81, '20:00'),
(82, '20:15'),
(83, '20:30'),
(84, '20:45'),
(85, '21:00'),
(86, '21:15'),
(87, '21:30'),
(88, '21:45'),
(89, '22:00'),
(90, '22:15'),
(91, '22:30'),
(92, '22:45'),
(93, '23:00'),
(94, '23:15'),
(95, '23:30'),
(96, '23:45'),
(97, '00:00'),
(98, '00:15'),
(99, '00:30'),
(100, '00:45'),
(101, '01:00'),
(102, '01:15'),
(103, '01:30'),
(104, '01:45'),
(105, '02:00'),
(106, '02:15'),
(107, '02:30'),
(108, '02:45'),
(109, '03:00'),
(110, '03:15'),
(111, '03:30'),
(112, '03:45'),
(113, '04:00'),
(114, '04:15'),
(115, '04:30'),
(116, '04:45'),
(117, '05:00'),
(118, '05:15'),
(119, '05:30'),
(120, '05:45'),
(121, '06:00'),
(122, '06:15'),
(123, '06:30'),
(124, '06:45'),
(125, '07:00'),
(126, '07:15'),
(127, '07:30'),
(128, '07:45'),
(129, '08:00'),
(130, '08:15'),
(131, '08:30'),
(132, '08:45'),
(133, '09:00'),
(134, '09:15'),
(135, '09:30'),
(136, '09:45'),
(137, '10:00'),
(138, '10:15'),
(139, '10:30'),
(140, '10:45'),
(141, '11:00'),
(142, '11:15'),
(143, '11:30'),
(144, '11:45'),
(145, '12:00'),
(146, '12:15'),
(147, '12:30'),
(148, '12:45'),
(149, '13:00'),
(150, '13:15'),
(151, '13:30'),
(152, '13:45'),
(153, '14:00'),
(154, '14:15'),
(155, '14:30'),
(156, '14:45'),
(157, '15:00'),
(158, '15:15'),
(159, '15:30'),
(160, '15:45'),
(161, '16:00'),
(162, '16:15'),
(163, '16:30'),
(164, '16:45'),
(165, '17:00'),
(166, '17:15'),
(167, '17:30'),
(168, '17:45'),
(169, '18:00'),
(170, '18:15'),
(171, '18:30'),
(172, '18:45'),
(173, '19:00'),
(174, '19:15'),
(175, '19:30'),
(176, '19:45'),
(177, '20:00'),
(178, '20:15'),
(179, '20:30'),
(180, '20:45'),
(181, '21:00'),
(182, '21:15'),
(183, '21:30'),
(184, '21:45'),
(185, '22:00'),
(186, '22:15'),
(187, '22:30'),
(188, '22:45'),
(189, '23:00'),
(190, '23:15'),
(191, '23:30'),
(192, '23:45');

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

--
-- Extraindo dados da tabela `orcamentostatus`
--

INSERT INTO `orcamentostatus` (`id`, `nome`) VALUES
(1, 'Orçamento Solicitado'),
(2, 'Orçamento Gerado'),
(3, 'Serviço Recusado'),
(4, 'Orçamento Aceito'),
(5, 'Orçamento Recusado'),
(6, 'Servico Cancelado'),
(7, 'Serviço Efetuado');

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

--
-- Extraindo dados da tabela `tipopagamento`
--

INSERT INTO `tipopagamento` (`id`, `nome`, `forma_pagamento`) VALUES
(1, 'Visa', 'Crédito'),
(2, 'MasterCard', 'Crédito'),
(3, 'Elo', 'Crédito'),
(4, ' American Express', 'Crédito'),
(5, 'Hipercard', 'Crédito'),
(6, 'Visa', 'Débito'),
(7, 'MasterCard', 'Débito'),
(8, 'Elo', 'Débito'),
(9, 'American Express', 'Débito'),
(10, 'Hipercard', 'Débito'),
(11, 'Itaú', 'Transferência/Pix'),
(12, 'Nubank', 'Transferência/Pix'),
(13, 'Santander', 'Transferência/Pix'),
(14, 'Bradesco', 'Transferência/Pix'),
(15, 'Caixa', 'Transferência/Pix'),
(16, 'Mercado Pago', 'Transferência/Pix'),
(17, 'PicPay', 'Transferência/Pix'),
(18, 'PayPal', 'Transferência/Pix'),
(19, 'Banco do Brasil', 'Transferência/Pix'),
(20, 'Boletos', 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tiposervico`
--

CREATE TABLE `tiposervico` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tiposervico`
--

INSERT INTO `tiposervico` (`id`, `nome`) VALUES
(1, 'Prestação de Serviço'),
(2, 'Locação de Equipamentos');

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

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `contrataservico`
--
ALTER TABLE `contrataservico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `controlevisualizacao`
--
ALTER TABLE `controlevisualizacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esquecisenha`
--
ALTER TABLE `esquecisenha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `horarioservico`
--
ALTER TABLE `horarioservico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listahorario`
--
ALTER TABLE `listahorario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orcamentostatus`
--
ALTER TABLE `orcamentostatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pagamentoservico`
--
ALTER TABLE `pagamentoservico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servico`
--
ALTER TABLE `servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipopagamento`
--
ALTER TABLE `tipopagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tiposervico`
--
ALTER TABLE `tiposervico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
