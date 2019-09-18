# 新闻类接口示例

---

## 目录

* [参考文档](#参考文档)
* [参数说明](#参数说明)
* [接口示例](#接口示例)
	* [获取数据支持include、fields请求参数](#获取数据支持include、fields请求参数)
	* [获取单条数据](#获取单条数据)
	* [获取多条数据](#获取多条数据)
	* [根据检索条件查询数据](#根据检索条件查询数据)	* [新增新闻](#新增新闻)
	* [编辑新闻](#编辑新闻)
	* [启用](#启用)
	* [禁用](#禁用)
	* [接口返回示例](#接口返回示例)
		* [单条数据接口返回示例](#单条数据接口返回示例)
		* [多条数据接口返回示例](#多条数据接口返回示例)

## <a name="参考文档">参考文档</a>

* 项目字典
	* [通用项目字典](./Docs/Dictionary/common.md "通用项目字典")
	* [新闻项目字典](./Docs/Dictionary/news.md "新闻项目字典")
	* [委办局项目字典](./Docs/Dictionary/userGroup.md "委办局项目字典")

*  控件规范
	* [通用控件规范](./Docs/WidgetRule/common.md "通用控件规范")
	* [新闻控件规范](./Docs/WidgetRule/news.md "新闻控件规范")

* 错误规范
	* [通用错误规范](./Docs/ErrorRule/common.md "通用错误规范")
	* [新闻错误规范](./Docs/ErrorRule/news.md "新闻错误规范")

## <a name="参数说明">参数说明</a>
     
| 英文名称         | 类型        |请求参数是否必填  |  示例                                        | 描述            |
| :---:           | :----:     | :------:      |:------------:                                |:-------:       |
| title           | string     | 是            | 中央财经领导小组办公室副主任韩俊                   | 新闻标题         |
| source          | string     | 是            | 中国网财经                                     | 新闻来源         |
| content         | string     | 是            | 新闻内容                                       | 新闻内容         |
| publishUserGroup| array      |               | array('id'=>1, 'name'=>''发展和改革委员会)      | 发布委办局        |
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

	$response = $client->request('GET', 'news/1?include=publishUserGroup&fields[userGroups]=name&fields[news]=title,source',['haders'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取单条数据">获取单条数据</a>

路由

	通过GET传参
	/news/{id:\d+}

示例

	$response = $client->request('GET', 'news/1',['haders'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取多条数据">获取多条数据</a>

路由

	通过GET传参
	/news/{ids:\d+,[\d,]+}

示例

	$response = $client->request('GET', 'news/1,2,3',['haders'=>['Content-' => 'application/vnd.api+json']]);

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

	$response = $client->request('GET', 'news?filter[publishUserGroup]=1&sort=-id&page[number]=1&page[size]=20',['haders'=>['Content-' => 'application/vnd.api+json']]);

### <a name="新增新闻">新增新闻</a>

路由

	通过POST传参
	/news

示例
	
	$data = array(
		"data"=>array(
			"type"=>"news",
			"attributes"=>array(
					"title"=>"标题",
					"source"=>"来源",
					"image"=>array('name'=>'图片名称', 'identify'=>'图片地址'),
					"attachments"=>array(
						array('name' => 'name', 'identify' => 'identify'),
						array('name' => 'name', 'identify' => 'identify'),
					),
				"content"=>"内容",
			),
			"relationships"=>array(
				"publishUserGroup"=>array(
					"data"=>array(
						array("type"=>"userGroups","id"=>委办局id)
					)
				)
			)
		)
	);
     		
	$response = $client->request(
		'POST',
		'news',
		[
			'haders'=>['Content-Type' => 'application/vnd.api+json'],
			'json' => $data
		]
	);

### <a name="编辑新闻">编辑新闻</a>

路由

	通过PATCH传参
	/news/{id:\d+}

示例

	$data = array(
		"data"=>array(
			"type"=>"news",
			"attributes"=>array(
					"title"=>"标题",
					"source"=>"来源",
					"image"=>array('name'=>'图片名称', 'identify'=>'图片地址'),
					"attachments"=>array(
						array('name' => 'name', 'identify' => 'identify'),
						array('name' => 'name', 'identify' => 'identify'),
					),
				"content"=>"内容",
			)
		)
	);
	
	$response = $client->request(
		'PATCH',
		'news/1',
		[
			'haders'=>['Content-Type' => 'application/vnd.api+json'],
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
				"title": "中央财经领导小组办公室副主任韩俊",
				"content": "中央财经领导小组办公室副主任韩俊",
				"source": "中国网财经",
				"attachments": [
					{
						"name": "关于印发《体育市场黑名单管理办法》通知",
						"identify": "关于印发《体育市场黑名单管理办法》通知.docx"
					},
					{
						"name": "关于印发《体育市场黑名单管理办法》通知.docx",
						"identify": "关于印发《体育市场黑名单管理办法》通知.docx"
					},
				],
				"image": {
					"name": "新闻图片",
					"identify": "o_1cli98qc9dfud59mf5ivkgm9r.jpg"
				},
				"status": 0,
				"createTime": 540504352,
				"updateTime": 1487420717,
				"statusTime": 950276494
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
	                "name": "萍乡市发展和改革委员会",
	                "status": 0,
	                "createTime": 341681353,
	                "updateTime": 297896598,
	                "statusTime": 1083013612
	            }
	        },
	    ]
	}
	
#### <a name="多条数据接口返回示例">多条数据接口返回示例</a>

	{
		"meta": {
			"count": 6,
			"links": {
				"first": 1,
				"last": 3,
				"prev": null,
				"next": 2
			}
		},
		"data": [
			{
				"type": "news",
				"id": "1",
				"attributes": { 
					"title": "中央财经领导小组办公室副主任韩俊",
					"source": "中国网财经",
					"status": 0,
					"createTime": 540504352,
					"updateTime": 1487420717,
					"statusTime": 1487420717
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
					"self": "127.0.0.1:8080/news/1"
				}
			},
			{
				"type": "news",
				"id": "2",
				"attributes": { 
					"title": "中央财经领导小组办公室副主任韩俊:农村",
					"source": "中国网财经",
					"status": 0,
					"createTime": 540504352,
					"updateTime": 1487420717,
					"statusTime": 1487420717
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
					"self": "127.0.0.1:8080/news/1"
				}
			},
		],
		"included": [
			{
				"type": "userGroups",
				"id": "1",
				"attributes": {
					"name": "萍乡市发展和改革委员会",
					"status": 0,
					"createTime": 1542174930,
					"updateTime": 1542174930,
					"statusTime": 0
				}
			},
			{
				"type": "userGroups",
				"id": "2",
				"attributes": {
					"name": "民政局",
					"status": 0,
					"createTime": 1542174930,
					"updateTime": 1542174930,
					"statusTime": 0
				}
			},
		]
	}