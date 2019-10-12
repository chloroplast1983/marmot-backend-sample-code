# 用户接口示例

---

## 目录

* [参考文档](#参考文档)
* [参数说明](#参数说明)
* [接口示例](#接口示例)
	* [获取数据支持include、fields请求参数](#获取数据支持include、fields请求参数)
	* [获取单条数据](#获取单条数据)
	* [获取多条数据](#获取多条数据)
	* [根据检索条件查询数据](#根据检索条件查询数据)
	* [注册](#注册)
	* [账号登录](#账号登录)
	* [接口返回示例](#接口返回示例)
		* [单条数据接口返回示例](#单条数据接口返回示例)
		* [多条数据接口返回示例](#多条数据接口返回示例)

## <a name="参考文档">参考文档</a>

* 项目字典
	* [通用项目字典](../Dictionary/common.md "通用项目字典")
	* [用户项目字典](../Dictionary/member.md "用户")
*  控件规范
	* [通用控件规范](../WidgetRule/common.md "通用控件规范")
	* [用户控件规范](../WidgetRule/member.md "用户控件规范")
* 错误规范
	* [通用错误规范](../ErrorRule/common.md "通用错误规范")
	* [用户错误规范](../ErrorRule/member.md "用户错误规范")

## <a name="参数说明">参数说明</a>
     
| 英文名称         | 类型        |请求参数是否必填  |  示例                                        | 描述            |
| :---:           | :----:     | :------:      |:------------:                                |:-------:       |
| cellphone       | string     | 是            | 13720406329                                  | 手机号          |
| userName        | string     | 是            | 13720406329                                  | 用户名          |
| realName        | string     | 是            | 张文                                          | 姓名           |
| cardId          | string     | 是            | 412825199408025763                           | 身份证号        |
| avatar          | array      | 是            | array("name"=>"头像", "identify"=>"1.jpg")    | 用户头像        |
| password        | string     | 是            | admin124                                     | 密码            |
| updateTime      | int        |               | 1535444931                                   | 更新时间         |
| creditTime      | int        |               | 1535444931                                   | 创建时间         |
| status          | int        |               | 0                                            | 状态  (0启用 -2禁用)|

## 接口示例

### <a name="获取数据支持include、fields请求参数">获取数据支持include、fields请求参数</a>

	1、include请求参数
	2、fields[TYPE]请求参数
	    2.1 fields[members]
	3、page请求参数
		3.1 page[number]=1 | 当前页
		3.2 page[size]=20 | 获取每页的数量

示例

	$response = $client->request('GET', 'members/1?fields[members]=cellphone,realName',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取单条数据">获取单条数据示例</a>

路由

	通过GET传参
	/members/{id:\d+}

示例

	$response = $client->request('GET', 'members/1',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="获取多条数据">获取多条数据示例</a>

路由

	通过GET传参
	/members/{ids:\d+,[\d,]+}

示例

	$response = $client->request('GET', 'members/1,2,3',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="根据检索条件查询数据">根据检索条件查询数据示例</a>

路由

	通过GET传参
	/members

	1、检索条件
	    1.1 filter[cellphone] | 根据手机号搜索 
	    1.2 filter[realName] | 根据姓名搜索 
	2、排序
		2.1 sort=-id | -id 根据id倒序 | id 根据id正序
		2.2 sort=-updateTime | -updateTime 根据更新时间倒序 | updateTime 根据更新时间正序

示例

	$response = $client->request('GET', 'members?filter[cellphone]=13720406432&sort=-id&page[number]=1&page[size]=20',['headers'=>['Content-' => 'application/vnd.api+json']]);

### <a name="注册">注册示例</a>

路由

	通过POST传参
	/members/signUp

示例

	$data = array("data"=>array("type"=>"members",
                        "attributes"=>array( 
                                            "cellphone"=>"18800000000",  
                                            "password"=>"123456"
                                           )
                       )
     		);
	$response = $client->request(
	                'POST',
	                'members/signUp',
	                [
	                'headers'=>['Content-Type' => 'application/vnd.api+json'],
	                'json' => $data
	                ]
	            );

### <a name="账号登录">账号登录示例</a>

路由

	通过POST传参
	/members/signIn

示例

	$data = array("data"=>array("type"=>"members",
                        "attributes"=>array(
                                            "passport"=>"18800000000",   
                                            "password"=>"123456"
                                           )
                       )
     		);
	$response = $client->request(
	                'POST',
	                'members/signIn',
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
			"type": "members",
			"id": "1",
			"attributes": {
				"cellphone": "18800000000",
				"userName": "18800000000",
				"realName": "张文",
				"cardId": "412825199009094553",
				"avatar": [],
				"status": 0,
				"createTime": 1516174523,
				"updateTime": 1516174523,
				"statusTime": 0
			},
			"links": {
				"self": "127.0.0.1:8081/members/1"
			}
		}
	}

#### <a name="多条数据接口返回示例">多条数据接口返回示例</a>

	{
		"meta": {
			"count": 1,
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
				"type": "members",
				"id": "1",
				"attributes": {
					"cellphone": "18800000000",
					"userName": "18800000000",
					"realName": "张文",
					"cardId": "412825199009094553",
					"avatar": [],
					"status": 0,
					"createTime": 1516174523,
					"updateTime": 1516174523,
					"statusTime": 0
				},
				"links": {
					"self": "127.0.0.1:8081/members/1"
				}
			}
		]
	}