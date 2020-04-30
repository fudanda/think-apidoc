<?php

namespace Fdd\ApiDoc;

class Doc
{
    public $config = [
        'title' => 'Api接口文档',
        'version' => '1.0.0',
        'copyright' => 'Powered By XXX',
        'password' => '',
        'prompt' => '', //温馨提示信息
        'delimiter' => '-', //解析器分割符默认'-',
        "explain" => [
            'name' => '说明',
            'list' => [
                '文档' => ['自动生成'],
            ]
        ],
        "code"    => [
            'name' => '返回信息',
            'list' => [
                'code'  => '【0成功】【1失败】【3Token验证失败,重新登录】',
                'msg'   => '提示信息',
                'count' => '分页时数据的总数量',
                'data'  => '数据',
                'jwt'   => 'Token信息,用于验证接口请求',
            ]
        ],
        'header' => [],
        'params' => [],
        'static_path' => '',
        'controller' => [],
        'filter_method' => ['_empty'],        # 过滤不需要解析的方法
        'return_format' => [
            'status' => "200/300/301/302",
            'message' => "提示信息",
        ]
    ];

    /**
     * 架构方法 设置参数
     *
     * @access public
     *
     * @param  array $config 配置参数
     */
    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 使用 $this->name 获取配置
     *
     * @access public
     *
     * @param  string $name 配置名称
     *
     * @return mixed    配置值
     */
    public function __get($name = null)
    {
        if ($name) {
            return $this->config[$name];
        } else {
            return $this->config;
        }
    }

    /**
     * 设置
     *
     * @access public
     *
     * @param  string $name  配置名称
     * @param  string $value 配置值
     *
     * @return void
     */
    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 检查配置
     *
     * @access public
     *
     * @param  string $name 配置名称
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }


    # 获取接口列表
    public function get_api_list($version = 0)
    {
        $controller = $this->config['controller'][$version]['list'];
        $list = [];
        foreach ($controller as $k => $class) {
            $class = "app\\" . $class;
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
        return $list;
    }

    /**
     * 获取接口详情
     * @param string $class
     * @param string $action
     *
     * @return array|bool
     */
    public function get_api_detail($class = '', $action = '')
    {
        $method = (new \ReflectionClass($class))->getMethod($action);
        return (new Extractor)->getDocCommentArr($method);
    }
}
