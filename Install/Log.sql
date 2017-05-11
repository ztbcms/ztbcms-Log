
# Dump of table cms_log_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cms_log_category`;

CREATE TABLE `cms_log_category` (
  `id` int(10) NOT NULL auto_increment COMMENT 'ID',
  `userid` int(10) NOT NULL COMMENT 'userid',
  `category` varchar(128) NOT NULL COMMENT '类名',
  `message` varchar(4098) NOT NULL COMMENT '日志信息',
  `inputtime` int NOT NULL COMMENT '添加时间',
  `ip` varchar(15) NOT NULL COMMENT 'ip地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;