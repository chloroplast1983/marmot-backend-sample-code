# 委办局接口示例

---

## 目录

* [参考文档](#参考文档)
* [参数说明](#参数说明)
* [接口示例](#接口示例)
	* [获取数据支持include、fields请求参数](#获取数据支持include、fields请求参数)
	* [获取单条数据](#获取单条数据)
	* [获取多条数据](#获取多条数据)
	* [根据检索条件查询数据](#根据检索条件查询数据)
	* [接口返回示例](#接口返回示例)
		* [单条数据接口返回示例](#单条数据接口返回示例)
		* [多条数据接口返回示例](#多条数据接口返回示例)

## <a name="参考文档">参考文档</a>

* 项目字典
	* [通用项目字典](../Dictionary/common.md "通用项目字典")
	* [委办局项目字典](../Dictionary/userGroup.md "委办局项目字典")

## <a name="参数说明">参数说明</a>
     
| 英文名称         | 类型        |请求参数是否必填  |  示例                                        | 描述            |
| :---:           | :----:     | :------:      |:------------:                                |:-------:       |
| name           | string     |             | 发展和改革委员会                   | 委办局名称         |
| updateTime      | int        |               | 1535444931                                   | 更新时间         |
| creditTime      | int        |               | 1535444931                                   | 创建时间         |
| status          | int        |               | 0                                            | 状态  (0默认)|

### <a name="获取数据支持include、fields请求参数">获取数据支持include、fields请求参数</a>

	1、include请求参数
	2、fields[TYPE]请求参数
	    2.1 fields[userGroups]
	3、page请求参数
		3.1 page[number]=1 | 当前页
		3.2 page[size]=20 | 获取每页的数量

示例

	$response = $client->request('GET', 'userGroups/1?fields[userGroups]=name',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取单条数据">获取单条数据</a>

路由

	通过GET传参
	/userGroups/{id:\d+}

示例

	$response = $client->request('GET', 'userGroups/1',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取多条数据">获取多条数据</a>

路由

	通过GET传参
	/userGroups/{ids:\d+,[\d,]+}

示例

	$response = $client->request('GET', 'userGroups/1,2,3',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="根据检索条件查询数据">根据检索条件查询数据</a>

路由

	通过GET传参
	/userGroups

	1、检索条件
	    1.1 filter[name] | 根据委办局名称搜索	
	2、排序
		2.1 sort=-id | -id 根据id倒序 | id 根据id正序

示例

	$response = $client->request('GET', 'userGroups?filter[name]=发展和改革委员会&sort=-id&page[number]=1&page[size]=20',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="接口返回示例">接口返回示例</a>

#### <a name="单条数据接口返回示例">单条数据接口返回示例</a>

	{
	    "meta": [],
	    "data": {
	        "type": "userGroups",
	        "id": "1",
	        "attributes": {
	            "name": "\u53d1\u5c55\u548c\u6539\u9769\u59d4\u5458\u4f1a",
	            "status": 0,
	            "createTime": 1516168970,
	            "updateTime": 1516168970,
	            "statusTime": 0
	        },
	        "links": {
	            "self": "127.0.0.1:8081\/userGroups\/1"
	        }
	    }
	}
	
#### <a name="多条数据接口返回示例">多条数据接口返回示例</a>

	{
	    "meta": {
	        "count": 13,
	        "links": {
	            "first": 1,
	            "last": 7,
	            "prev": null,
	            "next": 2
	        }
	    },
	    "links": {
	        "first": "127.0.0.1:8081\/userGroups\/?sort=-id&page[number]=1&page[size]=2",
	        "last": "127.0.0.1:8081\/userGroups\/?sort=-id&page[number]=7&page[size]=2",
	        "prev": null,
	        "next": "127.0.0.1:8081\/userGroups\/?sort=-id&page[number]=2&page[size]=2"
	    },
	    "data": [
	        {
	            "type": "userGroups",
	            "id": "13",
	            "attributes": {
	                "name": "\u53f8\u6cd5\u5c40",
	                "status": 0,
	                "createTime": 1516168970,
	                "updateTime": 1516168970,
	                "statusTime": 0
	            },
	            "links": {
	                "self": "127.0.0.1:8081\/userGroups\/13"
	            }
	        },
	        {
	            "type": "userGroups",
	            "id": "12",
	            "attributes": {
	                "name": "\u6559\u80b2\u5c40",
	                "status": 0,
	                "createTime": 1516168970,
	                "updateTime": 1516168970,
	                "statusTime": 0
	            },
	            "links": {
	                "self": "127.0.0.1:8081\/userGroups\/12"
	            }
	        }
	    ]
	}
