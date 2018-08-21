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