# 通用控件规范

### 控件类型(input,select...)-名称

**title** detail

#### 规则

* 控件规则1
* 控件规则2
* 控件规则3
* ....

#### 错误提示

* `ER-id1`
* `ER-id2`
* ...

---

## 通用项目规范

* `INPUT_TITLE`: 通用标题控件规范.
* `INPUT_IMAGE`: 图片控件规范.
* `INPUT_ATTACHMENTS`: 附件控件规范.

### `INPUT_TITLE`

**标题** 控件规范,用于表述标题

#### 规则

* string min:6|max:150

#### 错误提示

* `ER-0201`,标题长度范围为6-150

### `INPUT_IMAGE`

**图片** 控件规范，用于上传图片

#### 规则

* jpg,png,jpeg

#### 错误提示

* `ER-0202`: 图片格式错误.

### `INPUT_ATTACHMENTS`

**附件** 控件规范，用于上传附件

#### 规则

* 格式为zip, doc, docx，xls, xlsx

#### 错误提示

* `ER-0203`:附件格式错误