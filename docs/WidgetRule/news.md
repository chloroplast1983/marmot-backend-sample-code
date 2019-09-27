# 新闻类控件规范

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

## 新闻类

* `INPUT_NEWS_TITLE`: 新闻标题控件规范
* `INPUT_NEWS_SOURCE`: 新闻来源控件规范
* `INPUT_NEWS_CONTENT`: 新闻内容控件规范
* `INPUT_NEWS_IMAGE`: 新闻图片控件规范
* `INPUT_NEWS_ATTACHMENTS`: 新闻附件控件规范

### `INPUT_NEWS_TITLE`

* [标题](./common.md "标题")

### `INPUT_NEWS_SOURCE`

**新闻来源** 控件规范,用于表述新闻来源

#### 规则

* min: 2
* max: 15
* string
* notEmpty

#### 错误提示

* `ER-0101`,新闻来源不能为空
* `ER-1001`,新闻来源格式不正确

### `INPUT_NEWS_CONTENT`

**新闻内容** 控件规范,用于表述新闻内容

#### 规则

* min: 1
* max: 1000
* string
* notEmpty

#### 错误提示

* `ER-0101`,新闻内容不能为空
* `ER-1002`,新闻内容格式不正确

### `INPUT_NEWS_IMAGE`

* [图片](./common.md "图片")

### `INPUT_NEWS_ATTACHMENTS`

* [附件](./common.md "附件")