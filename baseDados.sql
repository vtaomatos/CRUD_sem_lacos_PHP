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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela crud_sem_lacos.noticia: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `noticia` DISABLE KEYS */;
REPLACE INTO `noticia` (`id`, `titulo`, `descricao`) VALUES
	(5, 'Testando complemento de slug', 'Estou editando essa notícia com o gerador de slug.'),
	(6, 'Testando complemento ', 'Vitor Augusto de Matos consegue fazer desafio de inserção de noticias.\r\nEsse desafio tem uma descrição com:\r\nQuebra de linhas;\r\nAcentuação;\r\nEtc..'),
	(13, 'Testando complemento de slug', 'AÇÃO');
/*!40000 ALTER TABLE `noticia` ENABLE KEYS */;

-- Copiando estrutura para tabela crud_sem_lacos.slug
CREATE TABLE IF NOT EXISTS `slug` (
  `id_slug` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `complemento` int(11) DEFAULT NULL,
  `id_noticia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_slug`),
  KEY `FK_slug_noticia` (`id_noticia`),
  CONSTRAINT `FK_slug_noticia` FOREIGN KEY (`id_noticia`) REFERENCES `noticia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela crud_sem_lacos.slug: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `slug` DISABLE KEYS */;
REPLACE INTO `slug` (`id_slug`, `slug`, `complemento`, `id_noticia`) VALUES
	(1, 'testando-complemento-de-slug', 2, 6),
	(2, 'testando-complemento', NULL, 5),
	(3, 'testando-complemento-de-slug', NULL, 13);
/*!40000 ALTER TABLE `slug` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
