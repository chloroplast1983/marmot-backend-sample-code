# 前台用户错误提示规范（2001-3000）

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

* ER-2001: 密码格式不正确
* ER-2002: 密码不正确
* ER-2003 - ER-3000: 前台用户错误预留

---

### <a name="ER-2001">ER-2001</a>

**id**

`2001`

**code**

`PASSWORD_FORMAT_ERROR`

**title**

密码格式不正确.

**detail**

密码格式不正确.

**links**

待补充

### <a name="ER-2002">ER-2002</a>

**id**

`2002`

**code**

`PASSWORD_INCORRECT`

**title**

密码不正确.

**detail**

密码不正确.

**links**

待补充

### ER-2003 - ER-3000 错误预留