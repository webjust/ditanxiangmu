# 给管理员日志添加用户名字段
ALTER TABLE `wx_admin_log`
  ADD COLUMN `admin_user` VARCHAR(30) NOT NULL DEFAULT ''
  AFTER `admin_id`;