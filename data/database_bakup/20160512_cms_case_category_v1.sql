DROP TABLE IF EXISTS cms_case_category
CREATE TABLE `cms_case_category` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '栏目ID',  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目ID',  `name` varchar(50) NOT NULL COMMENT '栏目名称',  `description` text,  `seq` int(11) NOT NULL DEFAULT '0' COMMENT '栏目排序',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8
