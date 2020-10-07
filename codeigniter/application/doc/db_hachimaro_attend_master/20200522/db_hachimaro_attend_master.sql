CREATE TABLE IF NOT EXISTS  `db_hachimaro_attend_master`.`employee` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '社員ID',
  `name` varchar(50) NOT NULL COMMENT '社員名',
  `birthday` datetime DEFAULT NULL COMMENT '誕生日',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '生成時間',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '削除時間',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社員管理';
