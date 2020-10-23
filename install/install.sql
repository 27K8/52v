
DROP TABLE IF EXISTS `tyys_user`;
CREATE TABLE `tyys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `vip` int(2) NOT NULL DEFAULT '0',
  `recommend` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `score` float NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `create_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `login_time` int(11) NOT NULL DEFAULT '0',
  `login_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `last_login_time` int(11) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `expir_time` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `tyys_user`(`id`,`username`,`password`,`vip`,`recommend`,`email`,`score`,`create_time`,`create_ip`,`expir_time`,`status`) values
(1,'tyyule','123456',99,0,'nyqy@qq.com',999.9,1522280417,'125.64.219.141',9999999999,1);

DROP TABLE IF EXISTS `tyys_card`;
CREATE TABLE `tyys_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(255) NOT NULL DEFAULT 'not',
  `card_type_id` int(11) NOT NULL DEFAULT '0',
  `card_vip` int(2) NOT NULL DEFAULT 1, 
  `use_user_id` int(11) DEFAULT NULL,
  `use_user` varchar(255) DEFAULT NULL, 
  `use_time` int(11) NOT NULL DEFAULT '0',
  `use_ip` varchar(255) DEFAULT NULL,  
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='卡密列表';

DROP TABLE IF EXISTS `tyys_card_type`;
CREATE TABLE `tyys_card_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'not',
  `value` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(255) NOT NULL DEFAULT 'day',
  `comment` text,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='卡密类型';

INSERT INTO `tyys_card_type` (`id`, `name`, `value`, `unit`, `comment`, `status`) VALUES
(1, '一个月', 1, 'month', '使用时间为一个月', 1),
(2, '半年', 6, 'month', '使用时间为半年',  1),
(3, '一年', 1, 'year', '使用时间为一年', 1),
(4, '100点', 100, 'score', '100点', 1);