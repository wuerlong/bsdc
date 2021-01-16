INSERT INTO cms_friendlink VALUES('49','委办局','松江人才服务直达车','MjM5ODAxNjk3MA','','data/attachment/201605/20160509154055_67.png','99')
INSERT INTO cms_friendlink VALUES('50','委办局','松江报社','MjM5MDA5NDEzNg','','data/attachment/201604/20160428222138_66.png','22')
INSERT INTO cms_friendlink VALUES('51','委办局','微视松江','MzA3MDA0MTYxOQ','','data/attachment/201604/20160428222147_17.png','100')
DROP TABLE IF EXISTS cms_message
CREATE TABLE `cms_message` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',  `title` varchar(200) DEFAULT NULL,  `pic` varchar(500) DEFAULT NULL,  `province` varchar(100) DEFAULT NULL,  `city` varchar(500) DEFAULT NULL,  `company` varchar(500) DEFAULT NULL,  `inquiry` varchar(500) DEFAULT NULL,  `content` text,  `ip` varchar(20) DEFAULT NULL COMMENT '留言人IP',  `addtime` varchar(200) DEFAULT NULL COMMENT '留言日期',  `validate` int(11) NOT NULL DEFAULT '0',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8
INSERT INTO cms_message VALUES('1','test','data/attachment/201604/20160425064331_53.jpeg','','','','','测试','116.227.71.249','1461537811','0')
