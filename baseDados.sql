-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           10.1.25-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.5.0.5196
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
  `id_slug` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_noticia_slug` (`id_slug`),
  CONSTRAINT `FK_noticia_slug` FOREIGN KEY (`id_slug`) REFERENCES `slug` (`id_slug`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela crud_sem_lacos.noticia: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `noticia` DISABLE KEYS */;
REPLACE INTO `noticia` (`id`, `titulo`, `descricao`, `id_slug`) VALUES
	(5, 'Testando complemento de slug', 'Estou editando essa notícia com o gerador de slug.', 1),
	(6, 'Testando complemento ', 'Vitor Augusto de Matos consegue fazer desafio de inserção de noticias.\r\nEsse desafio tem uma descrição com:\r\nQuebra de linhas;\r\nAcentuação;\r\nEtc..', 2),
	(13, 'Testando complemento de slug', 'AÇÃO', 3);
/*!40000 ALTER TABLE `noticia` ENABLE KEYS */;

-- Copiando estrutura para tabela crud_sem_lacos.slug
CREATE TABLE IF NOT EXISTS `slug` (
  `id_slug` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `complemento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela crud_sem_lacos.slug: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `slug` DISABLE KEYS */;
REPLACE INTO `slug` (`id_slug`, `slug`, `complemento`) VALUES
	(1, 'testando-complemento-de-slug', 2),
	(2, 'testando-complemento', NULL),
	(3, 'testando-complemento-de-slug', NULL);
/*!40000 ALTER TABLE `slug` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
