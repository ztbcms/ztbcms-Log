
# Dump of table cms_log_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cms_log_log`;

CREATE TABLE `cms_log_log` (
  `id` int(10) NOT NULL auto_increment COMMENT 'ID',
  `category` varchar(128) NOT NULL COMMENT '类别',
  `message` varchar(4098) NOT NULL COMMENT '日志信息',
  `inputtime` int NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;