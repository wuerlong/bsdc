INSERT INTO cms_category VALUES('2','0','松江味道','','0')
DROP TABLE IF EXISTS cms_comment
CREATE TABLE `cms_comment` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',  `article_id` int(11) NOT NULL,  `userid` int(11) NOT NULL DEFAULT '0',  `username` varchar(255) NOT NULL,  `email` varchar(255) NOT NULL,  `title` varchar(200) NOT NULL,  `content` text NOT NULL,  `reply` text NOT NULL,  `addtime` varchar(255) NOT NULL,  `replytime` varchar(255) NOT NULL,  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态（1 发布 0 禁用）',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8
DROP TABLE IF EXISTS cms_file
CREATE TABLE `cms_file` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `filename` varchar(200) DEFAULT NULL,  `ffilename` varchar(200) DEFAULT NULL,  `path` varchar(250) DEFAULT NULL,  `ext` varchar(10) DEFAULT NULL,  `size` int(11) DEFAULT NULL,  `upload_date` datetime DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8
INSERT INTO cms_file VALUES('1','20160419104816_75.jpg','pic01.jpg','data/attachment/201604/20160419104816_75.jpg','jpg','47787','2016-04-19 10:48:16')
