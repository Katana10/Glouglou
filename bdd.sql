#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


#------------------------------------------------------------
# Delete database
#------------------------------------------------------------
DROP DATABASE IF EXISTS plongeur;
DROP USER IF EXISTS 'plongeur'@'localhost';

#------------------------------------------------------------
# Create database
#------------------------------------------------------------
CREATE DATABASE plongeur;

#------------------------------------------------------------
# Create user
#------------------------------------------------------------
# Grand manitou
CREATE USER 'plongeur'@'localhost' IDENTIFIED BY 'GrandBleu$1';
GRANT ALL PRIVILEGES ON plongeur.* TO 'plongeur'@'localhost';


FLUSH PRIVILEGES;