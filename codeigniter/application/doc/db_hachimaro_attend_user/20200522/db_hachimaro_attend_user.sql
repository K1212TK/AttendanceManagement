CREATE TABLE IF NOT EXISTS `db_hachimaro_attend_user`.`punch` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '管理ID',
  `emp_id` INT NOT NULL COMMENT '社員ID',
  `punch_in` TIMESTAMP NULL DEFAULT NULL COMMENT '出勤時刻',
  `punch_out` TIMESTAMP NULL DEFAULT NULL COMMENT '退勤時刻',
  `punch_state` TINYINT NULL DEFAULT 0 COMMENT '出勤:1 退勤:2',
  `fix_state` TINYINT NULL DEFAULT 0 COMMENT '修正済み:1',
  `del_state` TINYINT NULL DEFAULT 0 COMMENT '削除済み:1',
  PRIMARY KEY (`id`))
COMMENT = '勤怠管理';
