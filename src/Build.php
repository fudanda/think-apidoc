<?php

namespace Fdd\ApiDoc;

use Fdd\ApiDoc\Extractor;
use think\facade\Config;

class Build
{
    protected $config = [];

    public function __construct($config = [])
    {
        if (empty($config)) {
            $config = Config::get('apiconfig');
        }
        $this->config = array_merge($this->config, $config);
    }

    # 获取接口列表
    public static function make($config = [])
    {
        return new self($config);
    }

    # 获取接口列表
    public function list()
    {
        // $controller = $this->config['controller'][$version]['list'];
        // dump($this->config['controller']);

        $controllerList = $this->config['controller'];
        $list = [];
        foreach ($controllerList as $i => $value) {
            foreach ($value['list'] as $k => $class) {

                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $doc_str = $reflection->getDocComment();
                    $doc = new Extractor();
                    # 解析类
                    $class_doc = $doc->parseClass($doc_str);
                    $list[$k] = $class_doc;
                    $list[$k]['class'] = $class;

                    $method = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
                    # 过滤不需要解析的方法以及非当前类的方法(父级方法)
                    $filter_method = array_merge(['__construct'], $this->config['filter_method']);
                    foreach ($method as $key => $action) {
                        if (!in_array($action->name, $filter_method) && $action->class === $class) {
                            if ($doc->parseAction($action))
                                $list[$k]['action'][$key] = $doc->parseAction($action);
                        }
                    }
                }
            }
        }
        return $list;
    }


    public function initMenu($apiMenu = [])
    {
        $jsonFilePath = file_build_path(__DIR__, 'view', 'api', 'init.json');
        $json_string = file_get_contents($jsonFilePath);
        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);
        $data['menuInfo'] = [];
        $data['menuInfo'][] = $apiMenu;
        $json_string = json_encode($data, JSON_UNESCAPED_UNICODE);
        // 写入文件
        file_put_contents($jsonFilePath, $json_string);
    }
    public function formattingMenu($apiMenu = [])
    {
        $top = $this->config['controller'];
        $super = [];
        foreach ($apiMenu as $k => &$v) {
            $super[$k]['title'] = $v['ApiTitle'];
            $super[$k]['icon'] = 'fa fa-circle';
            $super[$k]['href'] = '';
            $super[$k]['target'] = '_self';
            $action = array_values($v['action']);
            $newMenu = [];
            foreach ($action as $i => $value) {

                $newMenu[$i]['title'] = $value['ApiTitle'];
                $newMenu[$i]['icon']   = 'fa fa-plug';
                $newMenu[$i]['href'] = "action?name={$value['href']}";
                $newMenu[$i]['target'] = '_self';
            }

            $super[$k]['child'] = array_values($newMenu);
        }
        foreach ($top as $key => &$value) {
            $value['title'] = $top[0]['name'];
            $value['icon'] = 'fa fa-circle';
            $value['href'] = '';
            $value['target'] = '_self';

            foreach ($value['list'] as $k => $list) {
                if (!array_key_exists($k, $super)) {
                    break;
                }
                $value['child'][] = $super[$k];
            }
        }

        $jsonFilePath = file_build_path(__DIR__, 'view', 'api', 'init.json');
        $json_string = file_get_contents($jsonFilePath);
        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);
        $data['menuInfo'] = [];
        $data['menuInfo'] = $top;
        return $data;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }
        return null;
    }

    /**
     * 获取接口详情
     * @param string $class
     * @param string $action
     *
     * @return array|bool
     */
    public function detail($class = '', $action = '')
    {
        $method = (new \ReflectionClass($class))->getMethod($action);
        return (new Extractor)->getDocCommentArr($method);
    }
}
