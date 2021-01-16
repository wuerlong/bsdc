DROP TABLE IF EXISTS cms_file
CREATE TABLE `cms_file` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `filename` varchar(200) DEFAULT NULL,  `ffilename` varchar(200) DEFAULT NULL,  `path` varchar(250) DEFAULT NULL,  `ext` varchar(10) DEFAULT NULL,  `size` int(11) DEFAULT NULL,  `upload_date` datetime DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8
INSERT INTO cms_file VALUES('1','20160419104816_75.jpg','pic01.jpg','data/attachment/201604/20160419104816_75.jpg','jpg','47787','2016-04-19 10:48:16')
INSERT INTO cms_file VALUES('2','20160419104923_83.jpg','pic02.jpg','data/attachment/201604/20160419104923_83.jpg','jpg','64934','2016-04-19 10:49:23')
INSERT INTO cms_file VALUES('3','20160422115059_72.jpg','pic05.jpg','data/attachment/201604/20160422115059_72.jpg','jpg','50796','2016-04-22 11:50:59')
INSERT INTO cms_file VALUES('4','20160422115141_37.jpg','pic06.jpg','data/attachment/201604/20160422115141_37.jpg','jpg','54604','2016-04-22 11:51:41')
INSERT INTO cms_file VALUES('5','20160422115215_77.jpg','pic07.jpg','data/attachment/201604/20160422115215_77.jpg','jpg','43123','2016-04-22 11:52:15')
