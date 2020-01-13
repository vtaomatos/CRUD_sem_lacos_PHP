-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.36-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.5.0.5349
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para crud_sem_lacos
CREATE DATABASE IF NOT EXISTS `crud_sem_lacos` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `crud_sem_lacos`;

-- Copiando estrutura para tabela crud_sem_lacos.noticia
CREATE TABLE IF NOT EXISTS `noticia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `descricao` longtext COLLATE latin1_general_ci,
  `slug` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `complemento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela crud_sem_lacos.noticia: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `noticia` DISABLE KEYS */;
INSERT IGNORE INTO `noticia` (`id`, `titulo`, `descricao`, `slug`, `complemento`) VALUES
	(5, 'Testando complemento de slug', 'Estou editando essa notÃ­cia com o gerador de slug.', 'esse-slug-e-um-teste-na-mao', NULL),
	(6, 'Testando complemento', 'Vitor Augusto de Matos consegue fazer desafio de inserÃ§Ã£o de noticias.\r\nEsse desafio tem uma descriÃ§Ã£o com:\r\nQuebra de linhas;\r\nAcentuaÃ§Ã£o;\r\nEtc..', 'testando-complemento', NULL),
	(13, 'Testando complemento de slug', 'AÃ?Ã?O', 'testando-complemento-de-slug', NULL);
/*!40000 ALTER TABLE `noticia` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
