DROP TABLE IF EXISTS cms_category
CREATE TABLE `cms_category` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '栏目ID',  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目ID',  `name` varchar(50) NOT NULL COMMENT '栏目名称',  `description` text,  `seq` int(11) NOT NULL DEFAULT '0' COMMENT '栏目排序',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8
INSERT INTO cms_category VALUES('1','0','松江印象','','0')
INSERT INTO cms_category VALUES('2','0','松江味道','','0')
