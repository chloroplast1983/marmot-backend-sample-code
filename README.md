# 后端样例代码

* 所有产出文档请统一放到`wiki`里面, 可以参见[框架wiki](https://github.com/chloroplast1983/marmot-framework)的样式
* 应用代码统一写到`src`内
* `controller`引用`jsonapi`原来是在`Common`内, 现在统一从`Marmot\Framework\Controller\JsonApiTrait`内引用
* `view`引用`jsonapi`特性原来是在`Common`内, 现在统一从`Marmot\Framework\View\JsonApiTrait`加载性状

### 目录

* [简介](#abstract)
* [沟通记录](#communicationRecord)
* [项目字典](#dictionary)
* [控件规范](#widgetRule)
* [错误规范](#errorRule)
* [接口示例](#api)
* [参考文档](#tutor)
* [版本记录](#version)

---

### <a name="abstract">简介</a>

用于 样例代码 后端服务.

---

### <a name="communicationRecord">沟通记录</a>

根据沟通日期命名.

---

### <a name="dictionary">项目字典</a>

* 通用字典 `common`
	* [通用字典](./Docs/Dictionary/common.md "通用字典")
* 新闻字典 `news`
	* [新闻字典](./Docs/Dictionary/news.md "新闻字典")
* 委办局字典 `userGroup`
	* [委办局字典](./Docs/Dictionary/userGroup.md "委办局字典")
* 用户字典 `member`
	* [用户字典](./Docs/Dictionary/member.md "用户字典")
* 民宿字典 `homestay`
	* [民宿字典](./Docs/Dictionary/homestay.md "民宿字典")
	
---

### <a name="widgetRule">控件规范</a>

* 通用规范 `common`
	* [通用规范](./Docs/WidgetRule/common.md "通用规范")
* 新闻规范 `news`
	* [新闻规范](./Docs/WidgetRule/news.md "新闻规范")
* 用户规范 `member`
	* [用户规范](./Docs/WidgetRule/member.md "用户规范")
	
---

### <a name="errorRule">错误规范</a>

* 通用规范 `common`
	* [通用规范](./Docs/ErrorRule/common.md "通用规范")
* 新闻规范 `news`
	* [新闻规范](./Docs/ErrorRule/news.md "新闻规范")
* 用户规范 `member`
	* [用户规范](./Docs/ErrorRule/member.md "用户规范")
	
---

### <a name="api">接口示例</a>

* 新闻 `news`
	* [新闻](./Docs/Api/newsApi.md "新闻")
* 委办局 `userGroup`
	* [委办局](./Docs/Api/userGroupApi.md "委办局")
* 用户 `member`
	* [用户](./Docs/Api/memberApi.md "用户")
* 民宿 `homestay`
	* [民宿](./Docs/Api/homestayApi.md "民宿")

---

### <a name="tutor">参考文档</a>

* [jsonapi媒体协议](http://jsonapi.org/ "jsonapi")
* [框架](https://github.com/chloroplast1983/marmot) 

---

### <a name="version">版本记录</a>

* [0.1.0](./Docs/Version/0.1.0.md "0.1.0")