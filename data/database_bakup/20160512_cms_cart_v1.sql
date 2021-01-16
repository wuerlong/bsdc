DROP TABLE IF EXISTS cms_cart
CREATE TABLE `cms_cart` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',  `ordernum` varchar(255) NOT NULL,  `productid` int(11) NOT NULL,  `title` varchar(255) NOT NULL,  `pic` varchar(255) NOT NULL,  `price` varchar(255) NOT NULL,  `num` varchar(255) NOT NULL,  `userid` int(11) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8
