
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `path` varchar(120) NOT NULL,
  `text` varchar(3000) NOT NULL,
  `date` datetime DEFAULT NULL,
  `fileId` int(11) NOT NULL,
  `user` varchar(45) NOT NULL,
  `parentId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)


CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `size` double NOT NULL,
  `downloadDate` datetime NOT NULL,
  `extension` varchar(45) DEFAULT NULL,
  `userAuthKey` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_authKey_idx` (`userAuthKey`),
  CONSTRAINT `fk_authKey` FOREIGN KEY (`userAuthKey`) REFERENCES `user` (`authKey`)
) 

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(120) NOT NULL,
  `authKey` varchar(120) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `authKey_idx` (`authKey`)
) 