-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2015 at 01:34 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sgaaes`
--
CREATE DATABASE IF NOT EXISTS `sgaaes` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sgaaes`;

-- --------------------------------------------------------

--
-- Table structure for table `ajustes_de_ponto`
--

CREATE TABLE IF NOT EXISTS `ajustes_de_ponto` (
  `id` int(6) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id dos ajustes de ponto.',
  `alunos_id` int(6) unsigned zerofill NOT NULL COMMENT 'Vai armazenar as chaves primarias dos alunos.',
  `motivos_id` tinyint(3) unsigned zerofill DEFAULT NULL COMMENT 'Vai armazenar as chaves primarias dos motivos.',
  `data_ajuste` date NOT NULL COMMENT 'Vai armazenar as datas dos ajustes de ponto.',
  `tipo` char(2) DEFAULT NULL COMMENT 'Vai armazenar os tipos de ajustes de ponto.',
  `hora_entrada` time DEFAULT NULL COMMENT 'Vai armazenar os horários de entradas dos alunos referentes aos ajustes de ponto.',
  `hora_saida` time DEFAULT NULL COMMENT 'Vai armazenar os horários de saídas dos alunos referentes aos ajustes de ponto.',
  `status_ajuste` char(1) NOT NULL COMMENT 'Vai armazenar os status dos ajustes de ponto que são rejeitados, pendentes, solicitados e aceitos.',
  `observacao` text COMMENT 'Vai armazenar as observações referente aos ajustes de ponto.',
  `motivo_rejeicao` varchar(255) DEFAULT NULL COMMENT 'Irá armazenar o motivo da rejeição de um ajuste',
  `data_envio` date DEFAULT NULL COMMENT 'Irá armazenar a data em que o ajuste foi enviado.',
  `hora_envio` time DEFAULT NULL COMMENT 'Vai armazenar o horário em que o ajuste foi enviado.'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter os dados dos ajustes de pontos efetuadas.';

--
-- Dumping data for table `ajustes_de_ponto`
--

INSERT INTO `ajustes_de_ponto` (`id`, `alunos_id`, `motivos_id`, `data_ajuste`, `tipo`, `hora_entrada`, `hora_saida`, `status_ajuste`, `observacao`, `motivo_rejeicao`, `data_envio`, `hora_envio`) VALUES
(000001, 000002, 001, '2015-11-23', 'am', '10:10:00', '11:10:00', 's', 'Com muita dor de barriga', NULL, '2015-11-23', '10:13:00'),
(000002, 000002, 001, '2015-12-23', 'am', '08:10:00', '11:21:00', 'a', 'Quase morrendo de dor de barriga', '', '2015-11-23', '10:28:00'),
(000003, 000002, 002, '2015-10-10', 'ft', '00:00:00', '00:00:00', 'r', NULL, 'Data errada!', '2015-11-23', '10:29:00'),
(000004, 000002, 002, '2015-11-24', 'ft', '00:00:00', '00:00:00', 'p', NULL, NULL, '2015-11-23', '10:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `alunos`
--

CREATE TABLE IF NOT EXISTS `alunos` (
  `id` int(6) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id dos alunos cadastrados.',
  `usuarios_id` int(6) unsigned zerofill NOT NULL COMMENT 'Vai armazenar as chaves primarias dos usuários.',
  `turmas_id` int(4) unsigned zerofill NOT NULL COMMENT 'Vai armazenar as chaves primarias das turmas.',
  `equipes_id` int(5) unsigned zerofill DEFAULT NULL COMMENT 'Vai armazenar a chave primaria das equipes.',
  `nome_aluno` varchar(45) NOT NULL COMMENT 'Vai armazenar os nomes dos alunos cadastrados.',
  `epiteto` varchar(45) NOT NULL COMMENT 'Vai armazenar os apelidos dos alunos.',
  `email` varchar(90) NOT NULL COMMENT 'Vai armazenar os e-mails dos alunos cadastrados.',
  `foto` varchar(100) DEFAULT NULL COMMENT 'Vai armazenar a foto de cada aluno.'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter os dados dos alunos já registrados.';

--
-- Dumping data for table `alunos`
--

INSERT INTO `alunos` (`id`, `usuarios_id`, `turmas_id`, `equipes_id`, `nome_aluno`, `epiteto`, `email`, `foto`) VALUES
(000002, 000003, 0001, 00002, 'Karolaine Jaine', 'Jaine', 'jaine@gmail.com', '2311151448275871.jpg'),
(000003, 000004, 0001, 00001, 'Gabriela Gabardo', 'Gaba', 'gabi@gmail.com', '2311151448278146.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `alunos_has_anotacoes`
--

CREATE TABLE IF NOT EXISTS `alunos_has_anotacoes` (
  `alunos_id` int(6) unsigned zerofill NOT NULL COMMENT 'Contém as chaves primárias dos alunos.',
  `anotacoes_id` int(6) unsigned zerofill NOT NULL COMMENT 'Contém as chaves primárias das anotações.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alunos_has_anotacoes`
--

INSERT INTO `alunos_has_anotacoes` (`alunos_id`, `anotacoes_id`) VALUES
(000002, 000002),
(000003, 000002),
(000003, 000005);

-- --------------------------------------------------------

--
-- Table structure for table `anotacoes`
--

CREATE TABLE IF NOT EXISTS `anotacoes` (
  `id` int(6) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id das anotações.',
  `orientadores_id` int(4) unsigned zerofill NOT NULL COMMENT 'Vai armazenar a chave primaria dos orientadores.',
  `data_anotacao` date NOT NULL COMMENT 'Vai armazenar a data das anotações efetuadas.',
  `classificacao` char(3) NOT NULL COMMENT 'Vai armazenar as classificações das anotações tanto positiva,negativa ou neutra.',
  `anotacao` text NOT NULL COMMENT 'Vai armazenar as anotações efetuadas a cada aluno ou equipe.'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Nesta tabela vai conter os dados das anotações efetuadas.';

--
-- Dumping data for table `anotacoes`
--

INSERT INTO `anotacoes` (`id`, `orientadores_id`, `data_anotacao`, `classificacao`, `anotacao`) VALUES
(000002, 0002, '2015-11-23', 'neg', 'Conversam demais, além de não prestar atenção, retiram a atenção dos outros em classe.'),
(000005, 0002, '2015-11-23', 'pos', 'Aplicada e dedicada.');

-- --------------------------------------------------------

--
-- Table structure for table `equipes`
--

CREATE TABLE IF NOT EXISTS `equipes` (
  `id` int(5) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id das equipes.',
  `nome_equipe` varchar(45) NOT NULL COMMENT 'Vai armazenar os nomes das equipes.'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter os dados das equipes já registradas.';

--
-- Dumping data for table `equipes`
--

INSERT INTO `equipes` (`id`, `nome_equipe`) VALUES
(00001, 'Jaines'),
(00002, 'Gabardos');

-- --------------------------------------------------------

--
-- Table structure for table `equipes_has_anotacoes`
--

CREATE TABLE IF NOT EXISTS `equipes_has_anotacoes` (
  `equipes_id` int(5) unsigned zerofill NOT NULL COMMENT 'Contém a chave primária das equipes.',
  `anotacoes_id` int(6) unsigned zerofill NOT NULL COMMENT 'Contém as chaves primárias das anotações.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter as chaves primárias tanto de equipe quanto anotações.';

--
-- Dumping data for table `equipes_has_anotacoes`
--

INSERT INTO `equipes_has_anotacoes` (`equipes_id`, `anotacoes_id`) VALUES
(00001, 000002),
(00002, 000002);

-- --------------------------------------------------------

--
-- Table structure for table `motivos`
--

CREATE TABLE IF NOT EXISTS `motivos` (
  `id` tinyint(3) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id dos motivos.',
  `motivo` varchar(45) NOT NULL COMMENT 'Vai armazenar os motivos.',
  `descricao` text COMMENT 'Armazenará a descrição de casos de uso.'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter os dados dos motivos já registrados.';

--
-- Dumping data for table `motivos`
--

INSERT INTO `motivos` (`id`, `motivo`, `descricao`) VALUES
(001, 'Mal Estar ', 'Muita dor de barriga mesmo!'),
(002, 'Onibus', 'Onibus quebrou no caminho');

-- --------------------------------------------------------

--
-- Table structure for table `orientadores`
--

CREATE TABLE IF NOT EXISTS `orientadores` (
  `id` int(4) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id dos orientadores.',
  `usuarios_id` int(6) unsigned zerofill NOT NULL COMMENT 'Vai armazenar as chaves primarias de usuários.',
  `nome_orientador` varchar(45) NOT NULL COMMENT 'Vai armazenar os nomes dos orientadores.',
  `email` varchar(90) NOT NULL COMMENT 'Vai armazenar os e-mails dos orientadores.'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Na tabela orientadores contém os dados necessários dos orientadores registrados.';

--
-- Dumping data for table `orientadores`
--

INSERT INTO `orientadores` (`id`, `usuarios_id`, `nome_orientador`, `email`) VALUES
(0001, 000001, 'Giovane Delfino', 'giovane@gmail.com'),
(0002, 000005, 'Leandro Conradi', 'leandro@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orientadores_has_turmas`
--

CREATE TABLE IF NOT EXISTS `orientadores_has_turmas` (
  `orientadores_id` int(4) unsigned zerofill NOT NULL COMMENT 'Contém as chaves primárias dos orientadores.',
  `turmas_id` int(4) unsigned zerofill NOT NULL COMMENT 'Contém as chaves primárias das turmas.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter as chaves primárias dos orientadores e das turmas.';

--
-- Dumping data for table `orientadores_has_turmas`
--

INSERT INTO `orientadores_has_turmas` (`orientadores_id`, `turmas_id`) VALUES
(0001, 0001),
(0002, 0001),
(0001, 0002);

-- --------------------------------------------------------

--
-- Table structure for table `turmas`
--

CREATE TABLE IF NOT EXISTS `turmas` (
  `id` int(4) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id das turmas.',
  `nome_turma` varchar(45) NOT NULL COMMENT 'Vai armazenar os nomes das turmas .',
  `periodo` char(3) NOT NULL COMMENT 'Vai armazenar os períodos das turmas.',
  `modalidade` char(1) NOT NULL COMMENT 'Vai armazenar o nível de graduação (superior ou técnico.)',
  `status` char(1) NOT NULL COMMENT 'Ira armazenar o status da turma que pode ser ativo ou inativo.'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter os dados das turmas registradas.';

--
-- Dumping data for table `turmas`
--

INSERT INTO `turmas` (`id`, `nome_turma`, `periodo`, `modalidade`, `status`) VALUES
(0001, 'Pronatec Informática 2014', 'mat', 't', 'a'),
(0002, 'Pronatec informática 2014', 'ves', 't', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(6) unsigned zerofill NOT NULL COMMENT 'Vai armazenar o id dos usuários.',
  `login` varchar(45) NOT NULL COMMENT 'Vai  armazenar o login dos  usuários.',
  `senha` varchar(45) NOT NULL COMMENT 'Vai armazenar a senha cadastrada.',
  `permissao` char(1) NOT NULL COMMENT 'Vai armzenar a permissão dos usuários.'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Nesta tabela irá conter os dados dos usuários já registrados.';

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `senha`, `permissao`) VALUES
(000001, 'orientador', 'd2cf78cdab80b7b3a5fcb87933e476a4', '0'),
(000003, 'karolaine_jaine', '80c402dffa1174646f848da22c24eb12', '1'),
(000004, 'gabriela_gabardo', 'd3a3e5551ab81d283947f4772755176a', '1'),
(000005, 'Leandro', 'a24b4f9b9fcd3f1a6caae5775c331b3b', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajustes_de_ponto`
--
ALTER TABLE `ajustes_de_ponto`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_ajustes de ponto_motivos1_idx` (`motivos_id`), ADD KEY `fk_ajustes de ponto_alunos1_idx` (`alunos_id`);

--
-- Indexes for table `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_alunos_turmas_idx` (`turmas_id`), ADD KEY `fk_alunos_usuarios1_idx` (`usuarios_id`), ADD KEY `fk_alunos_equipes1_idx` (`equipes_id`);

--
-- Indexes for table `alunos_has_anotacoes`
--
ALTER TABLE `alunos_has_anotacoes`
  ADD PRIMARY KEY (`alunos_id`,`anotacoes_id`), ADD KEY `fk_alunos_has_anotacoes_anotacoes1_idx` (`anotacoes_id`), ADD KEY `fk_alunos_has_anotacoes_alunos1_idx` (`alunos_id`);

--
-- Indexes for table `anotacoes`
--
ALTER TABLE `anotacoes`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_anotacoes_orientadores1_idx` (`orientadores_id`);

--
-- Indexes for table `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipes_has_anotacoes`
--
ALTER TABLE `equipes_has_anotacoes`
  ADD PRIMARY KEY (`equipes_id`,`anotacoes_id`), ADD KEY `fk_equipes_has_anotacoes_anotacoes1_idx` (`anotacoes_id`), ADD KEY `fk_equipes_has_anotacoes_equipes1_idx` (`equipes_id`);

--
-- Indexes for table `motivos`
--
ALTER TABLE `motivos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orientadores`
--
ALTER TABLE `orientadores`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_orientadores_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `orientadores_has_turmas`
--
ALTER TABLE `orientadores_has_turmas`
  ADD PRIMARY KEY (`orientadores_id`,`turmas_id`), ADD KEY `fk_orientadores_has_turmas_turmas1_idx` (`turmas_id`), ADD KEY `fk_orientadores_has_turmas_orientadores1_idx` (`orientadores_id`);

--
-- Indexes for table `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajustes_de_ponto`
--
ALTER TABLE `ajustes_de_ponto`
  MODIFY `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id dos ajustes de ponto.',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id dos alunos cadastrados.',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id das anotações.',AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id das equipes.',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `motivos`
--
ALTER TABLE `motivos`
  MODIFY `id` tinyint(3) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id dos motivos.',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `orientadores`
--
ALTER TABLE `orientadores`
  MODIFY `id` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id dos orientadores.',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id das turmas.',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Vai armazenar o id dos usuários.',AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ajustes_de_ponto`
--
ALTER TABLE `ajustes_de_ponto`
ADD CONSTRAINT `fk_ajustes de ponto_alunos1` FOREIGN KEY (`alunos_id`) REFERENCES `alunos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ajustes de ponto_motivos1` FOREIGN KEY (`motivos_id`) REFERENCES `motivos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `alunos`
--
ALTER TABLE `alunos`
ADD CONSTRAINT `fk_alunos_equipes1` FOREIGN KEY (`equipes_id`) REFERENCES `equipes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_alunos_turmas` FOREIGN KEY (`turmas_id`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_alunos_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `alunos_has_anotacoes`
--
ALTER TABLE `alunos_has_anotacoes`
ADD CONSTRAINT `fk_alunos_has_anotacoes_alunos1` FOREIGN KEY (`alunos_id`) REFERENCES `alunos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_alunos_has_anotacoes_anotacoes1` FOREIGN KEY (`anotacoes_id`) REFERENCES `anotacoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `anotacoes`
--
ALTER TABLE `anotacoes`
ADD CONSTRAINT `fk_anotacoes_orientadores1` FOREIGN KEY (`orientadores_id`) REFERENCES `orientadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `equipes_has_anotacoes`
--
ALTER TABLE `equipes_has_anotacoes`
ADD CONSTRAINT `fk_equipes_has_anotacoes_anotacoes1` FOREIGN KEY (`anotacoes_id`) REFERENCES `anotacoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_equipes_has_anotacoes_equipes1` FOREIGN KEY (`equipes_id`) REFERENCES `equipes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `orientadores`
--
ALTER TABLE `orientadores`
ADD CONSTRAINT `fk_orientadores_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `orientadores_has_turmas`
--
ALTER TABLE `orientadores_has_turmas`
ADD CONSTRAINT `fk_orientadores_has_turmas_orientadores1` FOREIGN KEY (`orientadores_id`) REFERENCES `orientadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_orientadores_has_turmas_turmas1` FOREIGN KEY (`turmas_id`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
