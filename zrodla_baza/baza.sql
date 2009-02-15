
# Host: localhost (MySQL 5.0.51b)
# Database: gazeta
# Generation Time: 2009-01-03 13:51:18 +0100
# ************************************************************

# Dump of table artykul
# ------------------------------------------------------------

CREATE TABLE `artykul` (
  `id_art` int(11) NOT NULL auto_increment,
  `tytul` varchar(255) NOT NULL,
  `tresc` text NOT NULL,
  `data_godz` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `id_kat` int(11) NOT NULL,
  PRIMARY KEY  (`id_art`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2;


# Dump of table kategoria
# ------------------------------------------------------------

CREATE TABLE `kategoria` (
  `id_kat` int(11) NOT NULL auto_increment,
  `nazwa` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_kat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2;

INSERT INTO `kategoria` (`id_kat`,`nazwa`) VALUES ('1','domyslna');

# Dump of table komentarz
# ------------------------------------------------------------

CREATE TABLE `komentarz` (
  `id_kom` int(11) NOT NULL auto_increment,
  `tresc` text NOT NULL,
  `podpis` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_kom` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `id_art` int(11) NOT NULL,
  PRIMARY KEY  (`id_kom`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2;



# Dump of table redaktor
# ------------------------------------------------------------

CREATE TABLE `redaktor` (
  `id_redaktor` int(11) NOT NULL auto_increment,
  `login` varchar(255) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL default '0',
  `data_dolaczenia` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `bio` text,
  `usuniety` tinyint(1) default '0',
  PRIMARY KEY  (`id_redaktor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2;

INSERT INTO `redaktor` (`id_redaktor`,`login`,`haslo`,`email`,`admin`,`data_dolaczenia`,`bio`,`usuniety`) VALUES ('1','admin','0e311e5b9704f28b4e8557e8fa3fbe7d','anithaly@gmail.com','1','2009-01-01 12:00:00','','0');	

# Dump of table redaktor_artykul
# ------------------------------------------------------------

CREATE TABLE `redaktor_artykul` (
  `id_redaktor` int(11) NOT NULL,
  `id_art` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin2;
