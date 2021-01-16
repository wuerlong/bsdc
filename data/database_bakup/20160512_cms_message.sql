DROP TABLE IF EXISTS cms_message
CREATE TABLE `cms_message` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',  `title` varchar(200) DEFAULT NULL,  `pic` varchar(500) DEFAULT NULL,  `province` varchar(100) DEFAULT NULL,  `city` varchar(500) DEFAULT NULL,  `company` varchar(500) DEFAULT NULL,  `inquiry` varchar(500) DEFAULT NULL,  `content` text,  `ip` varchar(20) DEFAULT NULL COMMENT '留言人IP',  `addtime` varchar(200) DEFAULT NULL COMMENT '留言日期',  `validate` int(11) NOT NULL DEFAULT '0',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8
INSERT INTO cms_message VALUES('1','test','data/attachment/201604/20160425064331_53.jpeg','','','','','测试','116.227.71.249','1461537811','0')
INSERT INTO cms_message VALUES('2','你好','data/attachment/201604/20160425064621_78.jpeg','','','','','你好','116.227.71.249','1461537981','0')
INSERT INTO cms_message VALUES('9','你好','','','','','','我好','101.226.89.14','1462433958','0')
INSERT INTO cms_message VALUES('10','','','','','','','','121.42.0.35','1462499481','0')
INSERT INTO cms_message VALUES('14','测试','','','','','','测试','101.224.229.168','1462762507','0')
