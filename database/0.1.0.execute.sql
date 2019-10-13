use backend_sample;

CREATE TABLE `pcore_usergroup` (
  `usergroup_id` int(10) NOT NULL COMMENT '委办局主键id',
  `name` varchar(255) NOT NULL COMMENT '委办局名称',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) NOT NULL COMMENT '状态(STATUS_NORMAL,0,默认),(STATUS_DELETE,-2,删除)',
  `status_time` int(10) NOT NULL COMMENT '状态更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='委办局表';

ALTER TABLE `pcore_usergroup`
  ADD PRIMARY KEY (`usergroup_id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `pcore_usergroup`
  MODIFY `usergroup_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '委办局主键id';

CREATE TABLE `pcore_news` (
  `news_id` int(10) NOT NULL COMMENT '新闻id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `source` varchar(255) NOT NULL COMMENT '来源',
  `image` json NOT NULL COMMENT '图片',
  `attachments` json NOT NULL COMMENT '附件',
  `content` char(24) NOT NULL COMMENT '内容, mongo id',
  `publish_usergroup` int(10) NOT NULL COMMENT '发布单位id',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) NOT NULL COMMENT '状态(禁用 -2,  默认 启用 0)',
  `status_time` int(10) NOT NULL COMMENT '状态更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻表';

ALTER TABLE `pcore_news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `usergroup_title` (`publish_usergroup`,`title`);

ALTER TABLE `pcore_news`
  MODIFY `news_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '新闻id';

CREATE TABLE `pcore_member` (
  `member_id` int(10) NOT NULL COMMENT '用户主键id',
  `cellphone` char(11) DEFAULT NULL COMMENT '手机号',
  `user_name` varchar(255) NOT NULL COMMENT '用户名',
  `real_name` varchar(50) NOT NULL COMMENT '姓名',
  `cardid` char(18) NOT NULL COMMENT '身份证号',
  `avatar` json NOT NULL COMMENT '头像',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `salt` char(4) NOT NULL COMMENT '盐杂质',
  `status` tinyint(1) NOT NULL COMMENT '状态(默认 0 启用, -2 禁用)',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `status_time` int(10) NOT NULL COMMENT '状态更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

ALTER TABLE `pcore_member`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `cellphone` (`cellphone`);

ALTER TABLE `pcore_member`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户主键id', AUTO_INCREMENT=1;

CREATE TABLE `pcore_homestay` (
  `homestay_id` int(10) NOT NULL COMMENT '民宿主键id',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `logo` json NOT NULL COMMENT 'logo',
  `status` tinyint(1) NOT NULL COMMENT '状态(默认 0 待审核, 2 上架, -2 下架, -4 驳回)',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `status_time` int(10) NOT NULL COMMENT '状态更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='民宿表';

ALTER TABLE `pcore_homestay`
  ADD PRIMARY KEY (`homestay_id`);

ALTER TABLE `pcore_homestay`
  MODIFY `homestay_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '民宿主键id', AUTO_INCREMENT=1;
