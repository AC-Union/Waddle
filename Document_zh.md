# Waddle 文档

Waddle 是一个轻量级框架。

## 文件目录

见 `tree.md` 。

## 应用

### 基本概念

框架中，每个单独运行的 `Waddle` 实例拥有承载多个应用（或者称作服务）的能力。

每个应用单独位于 `app` 目录下的以应用名为目录名的目录中。

### 基本结构

每个应用必须拥有 `init.php`。
在 Waddle 框架启动时会自动调用每个应用的 `init.php`。
一个例子：

```php
<?php
    /**
     * Example Application
     */

    namespace App\Example; // 必须在 App\应用名 命名空间下

    // 实例化一个类型为 GraphQL 的 Waddle Application
    // 第一个参数必须是应用名，要求和目录名、命名空间名称一致。
    $app = new \Waddle\Application\GraphQL("Example");

    // 加载并解析位于 ./types/Query.graphql ，并绑定 QueryController
    // 为控制器。
    // 注意，第一个参数是 type 名称，该 graphql 文件内必须申明 Query 类型，
    // 且方法列表要与 QueryController 一一对应。
    // 第二个参数中 ::class 是取完整类名的意思。
    $app->loadType("Query", QueryController::class);

    // 也支持 Batch 写法
    $app->loadTypes([
        "Mutation" => MutationController::class,
        "User" => UserController::class
    ]);
    
    // 最后需要注册创建的 Application 实例
    \Waddle\Core::addApplication($app);

```

### Types 的说明

#### GraphQL 文件写法

可以参考 GraphQL 官方文档。scheme 只要出现一次即可。

#### Controller 写法

直接一个类即可。要求参数列表、返回值类型、函数名与 type 内定义的一致。

如果为常量，可以直接添加类属性。

## 热更新

执行

```bash
php ./waddleWatcher.php
```

即可。

## Middleware 写法

Middleware 需要实现 `\Waddle\Middleware\MiddlewareInterface` 接口。

两个方法， `request` 和 `response`。

```php
        /**
         * Request Event Handler
         *
         * @param array $header
         * @param string $body
         *
         * @return array
         */
        // 返回值为 修改过的 [$header, $body]。
        public function request($header, string $body) : array;

        /**
         * Response Event Handler
         *
         * @param \Waddle\Response $response
         *
         * @return \Waddle\Response
         */
        public function response(\Waddle\Response $response) : \Waddle\Response;
```

## 配置文件

在 `app/configure.json` 下，json 格式。

获取配置通过

```php
// $configureKey 是 配置的建，例如 {"a":{"b":{"c":123}}} 要获取 123 ，键就是 "a.b.c"。
\Waddle\Core::getConfig($configureKey);
```

## 访问方式

启动服务：

```bash
php ./waddle.php
```

端口和地址在配置文件定义。

访问 `http://ipaddr:port/应用名` 即可访问到应用。
若直接访问 `http://ipaddr:port/` ，默认使用 `Default` 应用。

支持 3 种请求方式：

1. POST Body 放一个 JSON 字符串，两个字段，query 和 variables ，分别是 GraphQL 请求 和 变量列表。
2. POST form-data query 和 variables 两个字段。
3. POST Body 放 GraphQL 请求，GET 参数放变量列表（variables）。

## RpcClient

对异步调用的封装。

## 其他

参考注释。