# 新闻类接口示例

---

## 目录

* [参考文档](#参考文档)
* [参数说明](#参数说明)
* [接口示例](#接口示例)
	* [获取数据支持include、fields请求参数](#获取数据支持include、fields请求参数)
	* [获取单条数据](#获取单条数据)
	* [获取多条数据](#获取多条数据)
	* [根据检索条件查询数据](#根据检索条件查询数据)
	* [新增](#新增)
	* [编辑](#编辑)
	* [启用](#启用)
	* [禁用](#禁用)
	* [接口返回示例](#接口返回示例)
		* [单条数据接口返回示例](#单条数据接口返回示例)
		* [多条数据接口返回示例](#多条数据接口返回示例)

## <a name="参考文档">参考文档</a>

* 项目字典
	* [通用项目字典](../Dictionary/common.md "通用项目字典")
	* [新闻项目字典](../Dictionary/news.md "新闻项目字典")
	* [委办局项目字典](../Dictionary/userGroup.md "委办局项目字典")
*  控件规范
	* [通用控件规范](../WidgetRule/common.md "通用控件规范")
	* [新闻控件规范](../WidgetRule/news.md "新闻控件规范")
* 错误规范
	* [通用错误规范](../ErrorRule/common.md "通用错误规范")
	* [新闻错误规范](../ErrorRule/news.md "新闻错误规范")

## <a name="参数说明">参数说明</a>
     
| 英文名称         | 类型        |请求参数是否必填  |  示例                                        | 描述            |
| :---:           | :----:     | :------:      |:------------:                                |:-------:       |
| title           | string     | 是            | 中央财经领导小组办公室副主任韩俊                   | 新闻标题         |
| source          | string     | 是            | 中国网财经                                     | 新闻来源         |
| content         | string     | 是            | 新闻内容                                       | 新闻内容         |
| publishUserGroup| array      | 是              | array('id'=>1, 'name'=>'发展和改革委员会')      | 发布委办局        |
| image           | array      | 是            | array("name"=>"新闻图片", "identify"=>"1.jpg") | 新闻图片         |
| attachments     | array      | 是            | array(array"name"=>"新闻附件", "identify"=>"1.doc")) | 新闻附件   |
| updateTime      | int        |               | 1535444931                                   | 更新时间         |
| creditTime      | int        |               | 1535444931                                   | 创建时间         |
| status          | int        |               | 0                                            | 状态  (0启用 -2禁用)|

### <a name="获取数据支持include、fields请求参数">获取数据支持include、fields请求参数</a>

	1、include请求参数
	    1.1 include=publishUserGroup | 获取发布单位的include数据
	2、fields[TYPE]请求参数
	    2.1 fields[news]
	    2.2 fields[userGroups]
	3、page请求参数
		3.1 page[number]=1 | 当前页
		3.2 page[size]=20 | 获取每页的数量

示例

	$response = $client->request('GET', 'news/1?include=publishUserGroup&fields[userGroups]=name&fields[news]=title,source',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取单条数据">获取单条数据</a>

路由

	通过GET传参
	/news/{id:\d+}

示例

	$response = $client->request('GET', 'news/1',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取多条数据">获取多条数据</a>

路由

	通过GET传参
	/news/{ids:\d+,[\d,]+}

示例

	$response = $client->request('GET', 'news/1,2,3',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="根据检索条件查询数据">根据检索条件查询数据</a>

路由

	通过GET传参
	/news

	1、检索条件
	    1.1 filter[title] | 根据标题搜索
	    1.2 filter[publishUserGroup] | 根据发布单位搜索
	    1.3 filter[status] | 根据状态搜索 | 0 启用 | -2 禁用	
	2、排序
		2.1 sort=-id | -id 根据id倒序 | id 根据id正序
		2.2 sort=-updateTime | -updateTime 根据更新时间倒序 | updateTime 根据更新时间正序
		2.3 sort=-status | -status 根据状态倒序 | status 根据状态正序

示例

	$response = $client->request('GET', 'news?filter[publishUserGroup]=1&sort=-id&page[number]=1&page[size]=20',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="新增">新增</a>

路由

	通过POST传参
	/news

示例
	
	$data = array(
		"data"=>array(
			"type"=>"news",
			"attributes"=>array(
					"title"=>"titletitletitletitle",
					"source"=>"source",
					"image"=>array('name'=>'图片名称', 'identify'=>'图片地址.jpg'),
					"attachments"=>array(
						array('name' => 'name', 'identify' => 'identify.docx'),
						array('name' => 'name', 'identify' => 'identify.docx'),
					),
				"content"=>"contentcontentcontentcontent"
			),
			"relationships"=>array(
				"publishUserGroup"=>array(
					"data"=>array(
						array("type"=>"userGroups","id"=>1)
					)
				)
			)
		)
	);
     		
	$response = $client->request(
		'POST',
		'news',
		[
			'headers'=>['Content-Type' => 'application/vnd.api+json'],
			'json' => $data
		]
	);

### <a name="编辑">编辑</a>

路由

	通过PATCH传参
	/news/{id:\d+}

示例

	$data = array(
		"data"=>array(
			"type"=>"news",
			"attributes"=>array(
					"title"=>"titletitletitletitle",
					"source"=>"source",
					"image"=>array('name'=>'图片名称', 'identify'=>'图片地址.jpg'),
					"attachments"=>array(
						array('name' => 'name', 'identify' => 'identify.docx'),
						array('name' => 'name', 'identify' => 'identify.docx'),
					),
				"content"=>"contentcontentcontentcontent"
			)
		)
	);
	
	$response = $client->request(
		'PATCH',
		'news/1',
		[
			'headers'=>['Content-Type' => 'application/vnd.api+json'],
			'json' => $data
		]
	);

### <a name="启用">启用</a>

路由

	通过PATCH传参
	/news/{id:\d+}/enable

示例

	$response = $client->request('PATCH', 'news/1/enable',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="禁用">禁用</a>

路由

	通过PATCH传参
	/news/{id:\d+}/disable

示例

	$response = $client->request('PATCH', 'news/1/disable',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="接口返回示例">接口返回示例</a>

#### <a name="单条数据接口返回示例">单条数据接口返回示例</a>

	{
	    "meta": [],
	    "data": {
	        "type": "news",
	        "id": "1",
	        "attributes": {
	            "title": "titletitletitletitletitle",
	            "source": "source",
	            "image": {
	                "name": "imagename",
	                "identify": "imageidentify.jpg"
	            },
	            "attachments": [
	                {
	                    "name": "attachmentsname",
	                    "identify": "attachmentsidentify1.docx"
	                },
	                {
	                    "name": "attachmentsname",
	                    "identify": "attachmentsidentify2.docx"
	                }
	            ],
	            "content": "contentcontentcontentcontentcontentcontentcontent\u5185\u5bb9\u5185\u5bb9\u5185\u5bb9\u5185\u5bb9contentcontentcontentcontentcontentcontent",
	            "status": 0,
	            "createTime": 1568945230,
	            "updateTime": 1568945230,
	            "statusTime": 0
	        },
	        "relationships": {
	            "publishUserGroup": {
	                "data": {
	                    "type": "userGroups",
	                    "id": "1"
	                }
	            }
	        },
	        "links": {
	            "self": "127.0.0.1:8081\/news\/1"
	        }
	    },
	    "included": [
	        {
	            "type": "userGroups",
	            "id": "1",
	            "attributes": {
	                "name": "\u53d1\u5c55\u548c\u6539\u9769\u59d4\u5458\u4f1a"
	            }
	        }
	    ]
	}
	
#### <a name="多条数据接口返回示例">多条数据接口返回示例</a>

	{
	    "meta": {
	        "count": 6,
	        "links": {
	            "first": 1,
	            "last": 2,
	            "prev": null,
	            "next": 2
	        }
	    },
	    "links": {
	        "first": "127.0.0.1:8081\/news\/?include=publishUserGroup&fields[userGroups]=name&sort=-id&page[number]=1&page[size]=3",
	        "last": "127.0.0.1:8081\/news\/?include=publishUserGroup&fields[userGroups]=name&sort=-id&page[number]=2&page[size]=3",
	        "prev": null,
	        "next": "127.0.0.1:8081\/news\/?include=publishUserGroup&fields[userGroups]=name&sort=-id&page[number]=2&page[size]=3"
	    },
	    "data": [
	        {
	            "type": "news",
	            "id": "6",
	            "attributes": {
	                "title": "titletitletitletitletitle",
	                "source": "source",
	                "image": {
	                    "name": "imagename",
	                    "identify": "imageidentify.jpg"
	                },
	                "attachments": [
	                    {
	                        "name": "attachmentsname",
	                        "identify": "attachmentsidentify1.docx"
	                    },
	                    {
	                        "name": "attachmentsname",
	                        "identify": "attachmentsidentify2.docx"
	                    }
	                ],
	                "content": "",
	                "status": 0,
	                "createTime": 1568945265,
	                "updateTime": 1568945265,
	                "statusTime": 0
	            },
	            "relationships": {
	                "publishUserGroup": {
	                    "data": {
	                        "type": "userGroups",
	                        "id": "4"
	                    }
	                }
	            },
	            "links": {
	                "self": "127.0.0.1:8081\/news\/6"
	            }
	        },
	        {
	            "type": "news",
	            "id": "5",
	            "attributes": {
	                "title": "titletitletitletitletitle",
	                "source": "source",
	                "image": {
	                    "name": "imagename",
	                    "identify": "imageidentify.jpg"
	                },
	                "attachments": [
	                    {
	                        "name": "attachmentsname",
	                        "identify": "attachmentsidentify1.docx"
	                    },
	                    {
	                        "name": "attachmentsname",
	                        "identify": "attachmentsidentify2.docx"
	                    }
	                ],
	                "content": "",
	                "status": 0,
	                "createTime": 1568945263,
	                "updateTime": 1568945263,
	                "statusTime": 0
	            },
	            "relationships": {
	                "publishUserGroup": {
	                    "data": {
	                        "type": "userGroups",
	                        "id": "4"
	                    }
	                }
	            },
	            "links": {
	                "self": "127.0.0.1:8081\/news\/5"
	            }
	        },
	        {
	            "type": "news",
	            "id": "4",
	            "attributes": {
	                "title": "titletitletitletitletitle",
	                "source": "source",
	                "image": {
	                    "name": "imagename",
	                    "identify": "imageidentify.jpg"
	                },
	                "attachments": [
	                    {
	                        "name": "attachmentsname",
	                        "identify": "attachmentsidentify1.docx"
	                    },
	                    {
	                        "name": "attachmentsname",
	                        "identify": "attachmentsidentify2.docx"
	                    }
	                ],
	                "content": "",
	                "status": 0,
	                "createTime": 1568945258,
	                "updateTime": 1568945258,
	                "statusTime": 0
	            },
	            "relationships": {
	                "publishUserGroup": {
	                    "data": {
	                        "type": "userGroups",
	                        "id": "2"
	                    }
	                }
	            },
	            "links": {
	                "self": "127.0.0.1:8081\/news\/4"
	            }
	        }
	    ],
	    "included": [
	        {
	            "type": "userGroups",
	            "id": "4",
	            "attributes": {
	                "name": "\u4eba\u6c11\u94f6\u884c\u4e2d\u5fc3\u652f\u884c"
	            }
	        },
	        {
	            "type": "userGroups",
	            "id": "2",
	            "attributes": {
	                "name": "\u5171\u9752\u56e2"
	            }
	        }
	    ]
	}