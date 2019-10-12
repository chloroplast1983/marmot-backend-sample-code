# 前台用户管理字典

### 英文名称

**中文名称** 描述信息

---

### cellphone

**手机号** 手机号的表述.

* string

### userName

**用户名** 用户名的表述,默认等于手机号.

* string 

### realName

**姓名** 姓名的表述.

* string

### cardId

**身份证号** 身份证号的表述.

* string

### avatar

**头像** 头像的表述.

* array
* array('name'=>'头像','identify'=>'头像.jpg')

### password

**密码** 密码的表述.

* string

### oldPassword

**旧密码** 旧密码的表述.

* string

### status

**状态** 状态的表述.

* int
	
	* STATUS_DISABLE = -2 //禁用
	* STATUS_ENABLE = 0 //启用
	
### [创建时间](./common.md)
### [更新时间](./common.md)
### [状态更新时间](./common.md)
### [状态更新时间](./user.md)