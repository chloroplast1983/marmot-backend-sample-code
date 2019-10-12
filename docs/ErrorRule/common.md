# 错误提示规范

* 通用错误提示规范（0001-1000）
* 新闻错误提示规范（1001-2000）
* 用户错误提示规范（2001-3000）

---

# 通用错误提示规范（0001-1000）

### ER-数字

**id**

错误的唯一id

**code**

程序用的错误状态码,用字符串表述

**title**

简短的,可读性高的问题总结.

**detail**

针对该问题的高可读性解释

**links**

可以在请求文档中取消应用的关联资源

---

* `ER-0000`: 未定义错误
* `ER-0001`: 程序错误
* `ER-0002`: 路由不存在
* `ER-0003`: 路由不支持该方法
* `ER-0004` - `ER-0009`: 系统错误预留
* `ER-0010`: 资源不存在
* `ER-0011`: 命令处理器不存在(程序内部用)
* `ER-0012`: `csrf`验证失败
* `ER-0013`: 滑动验证失败
* `ER-0014`: 用户未登录, 需要前端控制跳到登录页面
	* 用户退出后,访问页面, 返回该错误, 
* `ER-0015`: 同一账户多次登录, 先登录成功的用户被踢出.
* `ER-0016` - `ER-0099`: 系统错误预留
* `ER-0100`: 数据不能为空
* `ER-0101`: 数据重复
* `ER-0102`: 数据格式不正确
* `ER-0103`: 状态已禁用
* `ER-0104`: 状态已启用
* `ER-0105` - `ER-0200`: 映射错误预留
* `ER-0201`: 标题格式
* `ER-0202`: 图片格式不正确 
* `ER-0203`: 附件格式不正确 
* `ER-0204`: 姓名格式不正确 
* `ER-0205`: 手机号格式不正确 
* `ER-0206`: 价格格式不正确 
* `ER-0207`: 身份证格式不正确
* `ER-0208`: 日期格式不正确  
* `ER-0209`: 名称格式不正确 
* `ER-0210` - `ER-1000`: 通用错误预留

---

### <a name="ER-0000">ER-0000</a>

**id**

`0000`

**code**

`ERROR_NOT_DEFINED`

**title**

error not defined. 未定义错误.

**detail**

error not defined. 未定义错误.

**links**

待补充

### <a name="ER-0001">ER-0001</a>

**id**

`0001`

**code**

`INTERNAL_SERVER_ERROR`

**title**

internal server error. 服务器运行错误.

**detail**

internal server error. 服务器运行错误.

**links**

待补充

### <a name="ER-0002">ER-0002</a>

**id**

`0002`

**code**

`ROUTE_NOT_EXIST`

**title**

route not exist. 路由不存在.

**detail**

route not exist. 路由不存在.

**links**

待补充

### <a name="ER-0003">ER-0003</a>

**id**

`0003`

**code**

`METHOD_NOT_ALLOWED`

**title**

method not allowd. 路由不支持方法.

**detail**

method not allowd. 路由不支持方法.

**links**

待补充

### ER-0004 - ER-0009

系统错误预留字段.

### <a name="ER-0010">ER-0010</a>

**id**

`0010`

**code**

`RESOURCE_NOT_EXIST`

**title**

resource not exist. 资源不存在.

**detail**

server can not find resource. 服务器找不见资源.

**links**

待补充

### <a name="ER-0011">ER-0011</a>

**id**

`0011`

**code**

`COMMAND_HANDLER_NOT_EXIST`

**title**

command handler not exist. 命令处理器不存在.

**detail**

command handler not exist. 服务器找不见资源.

**links**

待补充

### <a name="ER-0012">ER-0012</a>

**id**

`0012`

**code**

`CSRF_VERIFY_FAILURE`

**title**

csrf 验证失效.

**detail**

csrf 验证失效.

**links**

待补充

### <a name="ER-0013">ER-0013</a>

**id**

`0013`

**code**

`AFS_VERIFY_FAILURE`

**title**

滑动验证失效.

**detail**

互动验证失效.

**links**

待补充

### <a name="ER-0014">ER-0014</a>

**id**

`0014`

**code**

`NEED_SIGNIN`

**title**

用户需要登录.

**detail**

用户需要登录.

**links**

待补充

### <a name="ER-0015">ER-0015</a>

**id**

`0015`

**code**

`USER_REPEATED_SIGNIN`

**title**

同一账户多次登录, 先登录成功的用户被踢出.

**detail**

同一账户多次登录, 先登录成功的用户被踢出.

**links**

待补充

### ER-0016 - ER-0099

错误预留字段

### <a name="ER-0100">ER-0100</a>

**id**

`0100`

**code**

`PARAMETER_IS_EMPTY`

**title**

表述一个不能为空的字段

**detail**

表述传输了一个空的字段,但是该字段不能为空.

**links**

待补充

### <a name="ER-0101">ER-0101</a>

**id**

`0101`

**code**

`PARAMETER_IS_UNIQUE`

**title**

表述一个不能重复的数据

**detail**

表述传输了一个已经存在的数据,但是该数据不能重复.

**links**

待补充

### <a name="ER-0102">ER-0102</a>

**id**

`0102`

**code**

`PARAMETER_FORMAT_ERROR`

**title**

格式不正确

**detail**

表述传输了一个格式不正确的字段.

**links**

待补充

### <a name="ER-0103">ER-0103</a>

**id**

`0103`

**code**

`RESOURCE_STATUS_DISABLED`

**title**

状态已禁用

**detail**

表述该资源状态已禁用.

**links**

待补充

### <a name="ER-0104">ER-0104</a>

**id**

`0104`

**code**

`RESOURCE_STATUS_ENABLED`

**title**

状态已启用

**detail**

表述该资源状态已启用.

**links**

待补充

ER-0105 - ER-0200

映射错误预留

### <a name="ER-0201">ER-0201</a>

**id**

`0201`

**code**

`TITLE_FORMAT_ERROR`

**title**

标题格式不正确

**detail**

标题长度范围为6-150

**links**

待补充

### <a name="ER-0202">ER-0202</a>

**id**

`0202`

**code**

`IMAGE_FORMAT_ERROR`

**title**

图片格式错误

**detail**

图片格式为jpg,png,jpeg

**links**

待补充

### <a name="ER-0203">ER-0203</a>

**id**

`0203`

**code**

`ATTACHMENT_FORMAT_ERROR`

**title**

附件格式错误

**detail**

附件格式为zip, doc, docx，xls, xlsx.

**links**

待补充

### <a name="ER-0204">ER-0204</a>

**id**

`0204`

**code**

`REAL_NAME_FORMAT_ERROR`

**title**

姓名格式错误.

**detail**

姓名格式错误.

**links**

待补充

### <a name="ER-0205">ER-0205</a>

**id**

`0205`

**code**

`CELLPHONE_FORMAT_ERROR`

**title**

手机号格式错误.

**detail**

手机号格式错误.

**links**

待补充

### <a name="ER-0206">ER-0206</a>

**id**

`0206`

**code**

`PRICE_FORMAT_ERROR`

**title**

价格格式错误.

**detail**

价格格式错误.

**links**

待补充

### <a name="ER-0207">ER-0207</a>

**id**

`0207`

**code**

`CARDID_FORMAT_ERROR`

**title**

身份证格式错误.

**detail**

身份证格式错误.

**links**

待补充

### <a name="ER-0208">ER-0208</a>

**id**

`0208`

**code**

`DATE_FORMAT_ERROR`

**title**

日期格式错误.

**detail**

日期格式错误,日期格式为'Y-m-d'.

**links**

待补充

### <a name="ER-0209">ER-0209</a>

**id**

`0209`

**code**

`NAME_FORMAT_ERROR`

**title**

名称格式不正确.

**detail**

名称格式不正确.

**links**

待补充

### `ER-0210` - `ER-1000`: 通用错误预留
