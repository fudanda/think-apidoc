<?php

use Fdd\ApiDoc\Utils;


# 当前URL
if (!function_exists("get_url")) {
    function get_url()
    {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self     = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info    = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url   = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
    }
}

if (!function_exists('jwt_json')) {
    /**
     * JWT 验证json
     * @param mixed $data
     * @param string $token
     * @return json
     */
    function jwt_json($data, $token = null)
    {
        $data['token'] = $token;
        return json($data);
    }
}

if (!function_exists('ajaxReturn')) {
    function ajaxReturn($status = 1, $msg = '', $count = 0, $data = array())
    {
        $result = array(
            'code' => $status,
            'msg' => $msg,
            'count' => $count,
            'data' => $data,
        );
        return json($result);
    }
}


if (!function_exists('jwt_encode')) {
    /**
     * 获取加密token
     * @param [array]  $data     用户信息
     * @param [string] $key      密钥
     * @param [int]    $expiration_time     过期时间
     * @param [string] $arithmetic     加密算法默认-HS256-[HS256,HS384,HS512,RS256,RS384,RS512]
     * @param [array]  $payload  配置
     * @return string
     */
    function jwt_encode($data = null, $key = null, $expiration_time = null, $arithmetic = null, $payload = null)
    {
        return  Utils::jwt_encode($data, $key, $expiration_time, $arithmetic, $payload);
    }
}
if (!function_exists('jwt_decode')) {
    /**
     * 解密token
     * @param [array]  $token     jwt信息
     * @param [string] $key      密钥
     * @param [string]    $arithmetic     加密算法默认-HS256-[HS256,HS384,HS512,RS256,RS384,RS512]
     * @return string
     */
    function jwt_decode($token = null,  $key = null, $arithmetic = null)
    {
        return  Utils::jwt_decode($token,  $key, $arithmetic);
    }
}
# 驼峰转下划线
if (!function_exists("hump_to_line")) {
    function hump_to_line($str)
    {
        $str = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        return $str;
    }
}

# curl $data有值是是post
if (!function_exists("http_curl")) {

    /**
     * curl模拟请求方法
     * @param $url
     * @param $cookie
     * @param array $data
     * @param $method
     * @param array $headers
     * @return mixed
     */
    function http_curl($url, $cookie, $data = array(), $method = 'GET', $headers = array())
    {
        $curl = curl_init();
        if ($data && count($data) && $method == "GET") {
            $data = array_filter($data);
            $url  .= "?" . http_build_query($data);
            $url  = str_replace(array('%5B0%5D'), array('[]'), $url);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if ($headers) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        $method = strtoupper($method);
        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        if (!empty($cookie)) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, true);
    }

    if (!function_exists('file_build_path')) {
        /**
         * 构建文件路径
         *
         * @param [string] ...$segments
         * @return void
         */
        function file_build_path(...$segments)
        {
            return join(DIRECTORY_SEPARATOR, $segments);
        }
    }
    if (!function_exists('mayBe')) {
        /**
         * 构建文件路径
         *
         * @param [string] ...$segments
         * @return bool
         */
        function mayBe(...$segments)
        {
            foreach ($segments as $value) {
                if ($value) {
                    return true;
                }
            }
            return false;
        }
    }
    if (!function_exists('isEmpty')) {
        /**
         * 构建文件路径
         *
         * @param [string] ...$segments
         * @return bool
         */
        function isEmpty($param)
        {
            $result = false;
            !isset($param) || !$param && $result = true;
            return $result;
        }
    }


    if (!function_exists('ajaxFail')) {
        /**
         * 返回失败
         *
         * @param string $msg
         * @param array $data
         * @param integer $count
         * @param integer $status
         * @return string
         */
        function ajaxFail($msg = null, $status = 1)
        {
            is_null($msg) && $msg = '失败';
            $result = array(
                'code' => $status,
                'msg' => $msg,
            );
            return json($result);
        }
    }
    if (!function_exists('ajaxSuccess')) {
        /**
         * 返回成功
         *
         * @param array $data
         * @param integer $count
         * @param [type] $msg
         * @param integer $status
         * @return string
         */
        function ajaxSuccess($data = null, $count = 0, $msg = null,  $status = 0)
        {
            is_null($msg) && $msg = '成功';
            $result       = [
                'code'  => $status,
                'msg'   => $msg,
                'count' => $count,
                'data'  => $data,
            ];
            return json($result);
        }
    }
}
