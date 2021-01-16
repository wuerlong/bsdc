DROP TABLE IF EXISTS cms_friendlink
CREATE TABLE `cms_friendlink` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',  `category` varchar(100) NOT NULL,  `name` varchar(200) NOT NULL COMMENT '网站名称',  `url` varchar(200) NOT NULL COMMENT '网址',  `description` varchar(400) NOT NULL COMMENT '站点简介',  `pic` varchar(500) NOT NULL COMMENT '网站LOGO',  `seq` int(11) NOT NULL DEFAULT '0' COMMENT '排列顺序',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8
INSERT INTO cms_friendlink VALUES('6','街道','永丰街道','MzA4OTQyMzEwNg','','data/attachment/201605/20160509153803_57.png','82')
INSERT INTO cms_friendlink VALUES('3','街道','中山街道','MzA5NjU3MjUwMA','','data/attachment/201604/20160428221108_91.png','80')
INSERT INTO cms_friendlink VALUES('7','街道','岳阳街道','MzAwNDE5MDQwMw','','data/attachment/201604/20160428221158_19.png','84')
INSERT INTO cms_friendlink VALUES('8','街道','车墩镇','MjM5NTc0Njk3NQ','','data/attachment/201604/20160428221210_55.png','85')
