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