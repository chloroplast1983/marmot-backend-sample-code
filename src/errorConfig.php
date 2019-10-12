<?php
/**
 * 1-99 系统错误规范
 * 100-500 通用错误规范
 * 501-1000 人通用错误提示规范
 * 1001-1500 新闻错误提示规范
 * 1501-2000 案例错误提示规范
 */

/**
 * 数据不能为空
 */
define('PARAMETER_IS_EMPTY', 100);
/**
 * 数据重复
 */
define('PARAMETER_IS_UNIQUE', 101);
/**
 * 数据格式不正确
 */
define('PARAMETER_FORMAT_ERROR', 102);
/**
 * 状态已禁用
 */
define('RESOURCE_STATUS_DISABLED', 103);
/**
 * 状态已启用
 */
define('RESOURCE_STATUS_ENABLED', 104);

/**
 * 标题格式不正确
 */
define('TITLE_FORMAT_ERROR', 201);
/**
 * 图片格式不正确
 */
define('IMAGE_FORMAT_ERROR', 202);
/**
 * 附件格式不正确
 */
define('ATTACHMENT_FORMAT_ERROR', 203);
/**
 * 姓名格式不正确
 */
define('REAL_NAME_FORMAT_ERROR', 204);
/**
 * 手机号格式不正确
 */
define('CELLPHONE_FORMAT_ERROR', 205);
/**
 * 价格格式不正确
 */
define('PRICE_FORMAT_ERROR', 206);
/**
 * 身份证格式不正确
 */
define('CARDID_FORMAT_ERROR', 207);
/**
 * 日期格式不正确
 */
define('DATE_FORMAT_ERROR', 208);
/**
 * 名称格式不正确
 */
define('NAME_FORMAT_ERROR', 209);
/**
 * 新闻来源格式不正确
 */
define('NEWS_SOURCE_FORMAT_ERROR', 1001);
/**
 * 新闻内容格式不正确
 */
define('NEWS_CONTENT_FORMAT_ERROR', 1002);
/**
 * 密码格式不正确
 */
define('PASSWORD_FORMAT_ERROR', 2001);
/**
 * 密码不正确
 */
define('PASSWORD_INCORRECT', 2002);
