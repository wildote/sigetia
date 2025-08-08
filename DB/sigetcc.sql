-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06-Nov-2021 às 19:46
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sigetcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `actividade`
--

CREATE TABLE `actividade` (
  `idActividade` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `descricao` text NOT NULL,
  `local` text NOT NULL,
  `data_inicio` date NOT NULL,
  `data_final` date NOT NULL,
  `data_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `actividade`
--

INSERT INTO `actividade` (`idActividade`, `titulo`, `descricao`, `local`, `data_inicio`, `data_final`, `data_criacao`) VALUES
(2, 'Entrega de Ultima Versao de Monografia', 'So eh possivel defender estudantes que cumprir com as datas prevista de entrega de TCC ', 'Computer Farm', '2019-12-05', '2019-12-10', '2019-12-08 23:10:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `nome` varchar(500) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_edicao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`nome`, `data_cadastro`, `data_edicao`) VALUES
('Desenho', '2019-11-13 19:46:54', '2019-11-13 19:46:54'),
('Geologia', '2019-11-12 20:07:44', '2019-11-12 20:07:44'),
('InformÃ¡tica', '2019-11-12 20:06:44', '2019-11-12 20:06:44');


-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `assunto` varchar(700) COLLATE utf8_bin NOT NULL,
  `msg` text COLLATE utf8_bin NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUsuario` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `assunto`, `msg`, `data`, `idUsuario`) VALUES
(5, 'Monografia', 'iyuyyteyeuyteuyeu6eu', '2019-11-18 05:56:20', 'Gzanda');

-- --------------------------------------------------------

--
-- Estrutura da tabela `monografias`
--

CREATE TABLE `monografias` (
  `id` int(11) NOT NULL,
  `tema` varchar(750) CHARACTER SET latin1 NOT NULL,
  `descricao` text CHARACTER SET latin1 NOT NULL,
  `url` varchar(750) CHARACTER SET latin1 NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '0',
  `idUsuario` varchar(100) CHARACTER SET latin1 NOT NULL,
  `obs` text NOT NULL,
  `idSupervisor` varchar(100) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_proj` int(11) NOT NULL,
  `idUserAprov` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `ID` bigint(20) NOT NULL,
  `Titulo` varchar(700) NOT NULL,
  `Texto` text NOT NULL,
  `id_nivel_acesso` tinyint(4) NOT NULL,
  `id_Usuario` varchar(100) NOT NULL,
  `id_Destinatario` varchar(100) NOT NULL,
  `Data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `notificacoes`
--

INSERT INTO `notificacoes` (`ID`, `Titulo`, `Texto`, `id_nivel_acesso`, `id_Usuario`, `id_Destinatario`, `Data`, `Estado`) VALUES
(52, 'Resposta!', 'Bla bla bla\r\n', 0, 'SU', 'Gzanda', '2019-11-18 12:22:19', 0),
(53, 'Resposta!', 'Volte a tentar!', 0, 'SU', 'Gzanda', '2019-11-18 12:22:35', 0),
(54, 'Novo projecto de TCC foi adicionado!', 'Novo projecto de TCC foi adicionado!', 1, 'Antonieta@gmail.com', '', '2019-12-08 15:06:58', 0),
(55, 'Novo projecto de TCC foi adicionado!', 'Novo projecto de TCC foi adicionado!', 1, 'Sara@gmail.com', '', '2019-12-08 15:13:34', 0),
(56, 'O seu projecto foi !', 'O seu projecto foi !', 0, 'H', 'Sara@gmail.com', '2019-12-08 15:18:44', 0),
(57, 'Resposta!', 'esta bem', 0, 'H', 'Sara@gmail.com', '2019-12-08 15:20:53', 0),
(58, 'O seu projecto foi Aprovado!', 'O seu projecto foi Aprovado!', 0, 'H', 'Antonieta@gmail.com', '2019-12-08 15:23:11', 0),
(59, 'Projecto', 'Foi selecionado como o supervisor do estudante Antonieta Pascoal', 0, 'H', 'Lussane@gmail.com', '2019-12-08 15:23:11', 0),
(60, 'Novo projecto de TCC foi adicionado!', 'Novo projecto de TCC foi adicionado!', 1, 'Sara@gmail.com', '', '2019-12-08 15:27:13', 0),
(61, 'Nova Monografia foi adicionada!', 'Nova Monografia foi adicionada!', 1, 'Antonieta@gmail.com', '', '2019-12-08 15:28:02', 0),
(62, 'Monografia carregada!', 'A monografica do supervisionando, Antonieta Pascoal foi carregada!', 0, 'Antonieta@gmail.com', 'Lussane@gmail.com', '2019-12-08 15:28:02', 0),
(63, 'O seu projecto foi Aprovado!', 'O seu projecto foi Aprovado!', 0, 'H', 'Sara@gmail.com', '2019-12-08 15:28:48', 0),
(64, 'Projecto', 'Foi selecionado como o supervisor do estudante Sara Maria', 0, 'H', 'Lussane@gmail.com', '2019-12-08 15:28:48', 0),
(65, 'Nova Monografia foi adicionada!', 'Nova Monografia foi adicionada!', 1, 'Sara@gmail.com', '', '2019-12-08 15:29:44', 0),
(66, 'Monografia carregada!', 'A monografica do supervisionando, Sara Maria foi carregada!', 0, 'Sara@gmail.com', 'Lussane@gmail.com', '2019-12-08 15:29:44', 0),
(67, 'A sua monografia foi !', 'A sua monografia foi !', 0, 'H', 'Sara@gmail.com', '2019-12-08 15:30:24', 0),
(68, 'Monografia', 'A monografia do estudante Sara Maria foi ', 0, 'H', 'Lussane@gmail.com', '2019-12-08 15:30:24', 0),
(69, 'A sua monografia foi Aprovado!', 'A sua monografia foi Aprovado!', 0, 'H', 'Antonieta@gmail.com', '2019-12-08 15:30:40', 0),
(70, 'Monografia', 'A monografia do estudante Antonieta Pascoal foi Aprovado', 0, 'H', 'Lussane@gmail.com', '2019-12-08 15:30:40', 0),
(71, 'Nova Monografia foi adicionada!', 'Nova Monografia foi adicionada!', 1, 'Sara@gmail.com', '', '2019-12-08 15:45:13', 0),
(72, 'Monografia carregada!', 'A monografica do supervisionando, Sara Maria foi carregada!', 0, 'Sara@gmail.com', 'Lussane@gmail.com', '2019-12-08 15:45:13', 0),
(73, 'A sua monografia foi !', 'A sua monografia foi !', 0, 'SU', 'Sara@gmail.com', '2019-12-08 15:45:39', 0),
(74, 'Monografia', 'A monografia do estudante Sara Maria foi ', 0, 'SU', 'Lussane@gmail.com', '2019-12-08 15:45:39', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projecto_tcc`
--

CREATE TABLE `projecto_tcc` (
  `id` int(11) NOT NULL,
  `tema` varchar(700) CHARACTER SET latin1 NOT NULL,
  `descricao` text CHARACTER SET latin1 NOT NULL,
  `url` varchar(700) CHARACTER SET latin1 NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '0',
  `idUsuario` varchar(50) CHARACTER SET latin1 NOT NULL,
  `obs` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `idSupervisor` varchar(25) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUserAprov` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela_nivel_acesso`
--

CREATE TABLE `tabela_nivel_acesso` (
  `idNivelAcesso` int(11) NOT NULL,
  `nomeNivelAcesso` varchar(50) NOT NULL,
  `DataCadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tabela_nivel_acesso`
--

INSERT INTO `tabela_nivel_acesso` (`idNivelAcesso`, `nomeNivelAcesso`, `DataCadastro`) VALUES
(1, 'Administrador', '2019-05-15'),
(2, 'Docente', '2017-08-24'),
(3, 'Estudante', '2017-08-24'),
(5, 'Super_Admin', '2019-11-13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela_usuarios`
--

CREATE TABLE `tabela_usuarios` (
  `idUsuario` varchar(100) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `celular` int(9) NOT NULL,
  `email` varchar(100) NOT NULL,
  `curso` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `idNivelAcesso` int(11) NOT NULL,
  `dataCadastro` date NOT NULL,
  `dataModificacao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tabela_usuarios`
--

INSERT INTO `tabela_usuarios` (`idUsuario`, `nome`, `celular`, `email`, `curso`, `departamento`, `senha`, `estado`, `idNivelAcesso`, `dataCadastro`, `dataModificacao`) VALUES
('SU', 'Super User', 856885969, 'su@co.mz', 'InformÃ¡tica', NULL, '25d55ad283aa400af464c76d713c07ad', 'Activo', 5, '2019-11-13', '2021-11-06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `descricao` text NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `estudante` varchar(50) NOT NULL,
  `data_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actividade`
--
ALTER TABLE `actividade`
  ADD PRIMARY KEY (`idActividade`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`nome`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monografias`
--
ALTER TABLE `monografias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tema` (`tema`);

--
-- Indexes for table `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `projecto_tcc`
--
ALTER TABLE `projecto_tcc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabela_nivel_acesso`
--
ALTER TABLE `tabela_nivel_acesso`
  ADD PRIMARY KEY (`idNivelAcesso`);

--
-- Indexes for table `tabela_usuarios`
--
ALTER TABLE `tabela_usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `celular` (`celular`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estudante` (`estudante`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actividade`
--
ALTER TABLE `actividade`
  MODIFY `idActividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `monografias`
--
ALTER TABLE `monografias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `projecto_tcc`
--
ALTER TABLE `projecto_tcc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tabela_nivel_acesso`
--
ALTER TABLE `tabela_nivel_acesso`
  MODIFY `idNivelAcesso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
