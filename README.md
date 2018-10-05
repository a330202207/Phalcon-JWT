# 代码规范
为了规范项目命名、接口参数命名、数据库表字段命名等
确保代码间具有较高程度的技术互通性


# 支付服务

## 项目结构

### 树状图
```shell
|-- apps        # 模块目录
|-- bin	        # 可执行文件目录（例如启动队列监听等操作）
|-- cache	# 缓存、日志等
|   |-- compiled
|   |-- data
|   `-- logs
|-- config	# 配置文件目录
|-- core        # 项目核心依赖
|   |-- base	# 基类目录(存放各种基类)
|   |-- common	# 函数库目录
|   `-- service	# 服务目录（存放基础服务）
|-- ide-helpers # 代码提示
|-- public	# 公共目录（对外提供访问）
```

### 模块结构

```shell
|-- config          # 模块配置
|   `-- config.php	# 模块配置文件
|-- controllers     # 控制器
|-- models	        # 模型
|-- services	    # 服务
|-- views	        # 视图
|-- Module.php	    # 模块核心文件
```