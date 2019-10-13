# 民宿接口示例

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
	* [接口返回示例](#接口返回示例)
		* [单条数据接口返回示例](#单条数据接口返回示例)
		* [多条数据接口返回示例](#多条数据接口返回示例)

## <a name="参考文档">参考文档</a>

* 项目字典
	* [通用项目字典](../Dictionary/common.md "通用项目字典")
	* [民宿项目字典](../Dictionary/homestay.md "民宿项目字典")
*  控件规范
	* [通用控件规范](../WidgetRule/common.md "通用控件规范")
* 错误规范
	* [通用错误规范](../ErrorRule/common.md "通用错误规范")

## <a name="参数说明">参数说明</a>
     
| 英文名称         | 类型        |请求参数是否必填  |  示例                                        | 描述            |
| :---:           | :----:     | :------:      |:------------:                                |:-------:       |
| name            | string      | 是            | 小雅山庄                                      | 民宿名称         |
| logo            | array      | 是            | array("name"=>"logo", "identify"=>"1.jpg")    | 民宿logo        |
| updateTime      | int        |               | 1535444931                                   | 更新时间         |
| creditTime      | int        |               | 1535444931                                   | 创建时间         |
| status          | int        |               | 0                                            | 状态  (0待审核, 2上架, -2下架, -4驳回)|

### <a name="获取数据支持include、fields请求参数">获取数据支持include、fields请求参数</a>

	1、fields[TYPE]请求参数
	    2.1 fields[homestaies]
	2、page请求参数
		3.1 page[number]=1 | 当前页
		3.2 page[size]=20 | 获取每页的数量

示例

	$response = $client->request('GET', 'homestaies/1?fields[userGroups]=name&fields[homestaies]=name',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取单条数据">获取单条数据</a>

路由

	通过GET传参
	/homestaies/{id:\d+}

示例

	$response = $client->request('GET', 'homestaies/1',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取多条数据">获取多条数据</a>

路由

	通过GET传参
	/homestaies/{ids:\d+,[\d,]+}

示例

	$response = $client->request('GET', 'homestaies/1,2,3',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="根据检索条件查询数据">根据检索条件查询数据</a>

路由

	通过GET传参
	/homestaies

	1、检索条件
	    1.1 filter[name] | 根据名称搜索
	    1.2 filter[status] | 根据状态搜索 | 0待审核, 2上架, -2下架, -4驳回	
	2、排序
		2.1 sort=-id | -id 根据id倒序 | id 根据id正序
		2.2 sort=-updateTime | -updateTime 根据更新时间倒序 | updateTime 根据更新时间正序
		2.3 sort=-status | -status 根据状态倒序 | status 根据状态正序

示例

	$response = $client->request('GET', 'homestaies?sort=-id&page[number]=1&page[size]=20',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="新增">新增</a>

路由

	通过POST传参
	/homestaies

示例
	
	$data = array(
		"data"=>array(
			"type"=>"homestaies",
			"attributes"=>array(
					"name"=>"民宿名称",
					"logo"=>array('name'=>'图片名称', 'identify'=>'图片地址.jpg'),
			)
		)
	);
     		
	$response = $client->request(
		'POST',
		'homestaies',
		[
			'headers'=>['Content-Type' => 'application/vnd.api+json'],
			'json' => $data
		]
	);

### <a name="编辑">编辑</a>

路由

	通过PATCH传参
	/homestaies/{id:\d+}

示例

	$data = array(
		"data"=>array(
			"type"=>"homestaies",
			"attributes"=>array(
					"name"=>"民宿名称",
					"logo"=>array('name'=>'图片名称', 'identify'=>'图片地址.jpg'),
			)
		)
	);
	
	$response = $client->request(
		'PATCH',
		'homestaies/1',
		[
			'headers'=>['Content-Type' => 'application/vnd.api+json'],
			'json' => $data
		]
	);

### <a name="接口返回示例">接口返回示例</a>

#### <a name="单条数据接口返回示例">单条数据接口返回示例</a>

	{
		"meta": [],
		"data": {
			"type": "homestaies",
			"id": "1",
			"attributes": {
				"name": "小雅山居",
				"logo": {
					"name": "小雅山居logo",
					"identify": "logo.jpg"
				},
				"status": 0,
				"createTime": 1570954300,
				"updateTime": 1570954300,
				"statusTime": 0
			},
			"links": {
				"self": "127.0.0.1:8081/homestaies/1"
			}
		}
	}

#### <a name="多条数据接口返回示例">多条数据接口返回示例</a>

	{
		"meta": {
			"count": 2,
			"links": {
				"first": null,
				"last": null,
				"prev": null,
				"next": null
			}
		},
		"links": {
			"first": null,
			"last": null,
			"prev": null,
			"next": null
		},
		"data": [
			{
				"type": "homestaies",
				"id": "1",
				"attributes": {
					"name": "小雅山居",
					"logo": {
						"name": "小雅山居logo",
						"identify": "logo.jpg"
					},
					"status": 0,
					"createTime": 1570954300,
					"updateTime": 1570954300,
					"statusTime": 0
				},
				"links": {
					"self": "127.0.0.1:8081/homestaies/1"
				}
			},
			{
				"type": "homestaies",
				"id": "2",
				"attributes": {
					"name": "精灵屋",
					"logo": {
						"name": "精灵屋logo",
						"identify": "logo.jpg"
					},
					"status": 0,
					"createTime": 1570954695,
					"updateTime": 1570956833,
					"statusTime": 0
				},
				"links": {
					"self": "127.0.0.1:8081/homestaies/2"
				}
			},
		]
	}