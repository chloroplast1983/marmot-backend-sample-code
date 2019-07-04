# 后端样例代码

* 所有产出文档请统一放到`wiki`里面, 可以参见[框架wiki](https://github.com/chloroplast1983/marmot-framework)的样式
* 应用代码统一写到`src`内
* `controller`引用`jsonapi`原来是在`Common`内, 现在统一从`Marmot\Framework\Controller\JsonApiTrait`内引用
* `view`引用`jsonapi`特性原来是在`Common`内, 现在统一从`Marmot\Framework\View\JsonApiTrait`加载性状