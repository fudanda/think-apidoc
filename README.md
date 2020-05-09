
# [fdd/think-apidoc](https://github.com/fudanda/phpHelper)

===============
> fdd/think-apidoc 的运行环境要求PHP5.6+。

适用于 [ThinkPHP5.1](http://thinkphp.cn) 自动生成API文档

## 主要新特性

* 暂无

## 依赖

* firebase/php-jwt

## 安装

~~~shell
composer require fdd/think-apidoc
~~~

## 使用

[Demo](./Demo.php)

## jwt使用

```php
<?php
use FuDanDa\ApiDoc\Utils;

$key = "example_key";
$nowtime = time();
$expiration_time = 7200
$payload = [
    'iss'  => 'http://example.com', //签发者
    'aud'  => 'http://example.com', //jwt所面向的用户
    'iat'  => $nowtime,            //签发时间
    'nbf'  => $nowtime,            //在什么时间之后该jwt才可用
    'exp'  => $nowtime + $expiration_time, //过期时间-120分钟
    'sub'  => '',                  //主题
    'jti'  => '',                   //JWT ID用于标识该JWT
    'data' => $data,                //自定义信息
];

 //加密token:
 Utils::jwt_encode();

 //自定义
 /**
    * @param [array]  $data     用户信息
    * @param [string] $key      密钥
    * @param [int]    $expiration_time     过期时间
    * @param [string] $arithmetic     加密算法默认-HS256-[HS256,HS384,HS512,RS256,RS384,RS512]
    * @param [array]  $payload  配置
 */
Utils::jwt_encode($data, $key, $expiration_time, $arithmetic, $payload);
//助手函数
jwt_encode();



 //解密token:
 Utils::jwt_decode();

 //自定义
/**
* @param [array]  $token     jwt信息
* @param [string] $key      密钥
* @param [string]    $arithmetic     加密算法默认-HS256-[HS256,HS384,HS512,RS256,RS38RS512]
* @return string
*/
Utils::jwt_decode($token,  $key, $arithmetic);
 //助手函数
 jwt_decode();
```
