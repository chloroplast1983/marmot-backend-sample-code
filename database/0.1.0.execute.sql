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
