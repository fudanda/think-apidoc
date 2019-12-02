<?php

namespace FuDanDa\ApiDoc;

use Firebase\JWT\JWT;

class Utils
{


    /**
     * 获取加密token
     * @param [array]  $data     用户信息
     * @param [string] $key      密钥
     * @param [int]    $expiration_time     过期时间
     * @param [string]    $arithmetic     加密算法默认-HS256-[HS256,HS384,HS512,RS256,RS384,RS512]
     * @param [array]   $payload  配置
     * @return string
     */
    public static function jwt_encode($data = null, $key = null, $expiration_time = null, $arithmetic = null, $payload = null)
    {
        $nowtime = time();
        $jwtkey = 'https://github.com/fudanda/think-apidoc';
        is_null($key) && $key = (config('api_config.jwtkey')) ?: $jwtkey;
        is_null($expiration_time) && $expiration_time = 7200;
        is_null($arithmetic) && $arithmetic = 'HS256';
        if (is_null($payload)) {
            $payload = [
                'iss'  => 'http://example.com', //签发者
                'aud'  => 'http://example.com', //jwt所面向的用户
                'iat'  => $nowtime,            //签发时间
                'nbf'  => $nowtime,            //在什么时间之后该jwt才可用
                'exp'  => $nowtime + $expiration_time, //过期时间-120分钟
                'sub'  => '',                  //主题
                'jti'  => '',                   //JWT ID用于标识该JWT
                'data' => $data,
            ];
        }
        $jwt = JWT::encode($payload, $key);
        return $jwt;
    }
    /**
     * 解密token
     * @param [array]  $token     jwt信息
     * @param [string] $key      密钥
     * @param [string]    $arithmetic     加密算法默认-HS256-[HS256,HS384,HS512,RS256,RS384,RS512]
     * @return string
     */
    public static function jwt_decode($token = null,  $key = null, $arithmetic = null)
    {
        dump($token);
        if (is_null($token)) {
            return false;
        }
        $jwtkey = 'https://github.com/fudanda/think-apidoc';
        is_null($key) && $key = (config('api_config.jwtkey')) ?: $jwtkey;
        is_null($arithmetic) && $arithmetic = 'HS256';
        $decode = JWT::decode($token, $key, array($arithmetic));
        return (array) $decode;
    }
}