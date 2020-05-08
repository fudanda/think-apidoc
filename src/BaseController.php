<?php

namespace Fdd\ApiDoc;

use think\facade\View;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * 二进制数据的文件类型
     */
    protected $mimeType = [
        'xml'  => 'application/xml,text/xml,application/x-xml',
        'json' => 'application/json,text/x-json,application/jsonrequest,text/json',
        'js'   => 'text/javascript,application/javascript,application/x-javascript',
        'css'  => 'text/css',
        'rss'  => 'application/rss+xml',
        'yaml' => 'application/x-yaml,text/yaml',
        'atom' => 'application/atom+xml',
        'pdf'  => 'application/pdf',
        'text' => 'text/plain',
        'png'  => 'image/png',
        'jpg'  => 'image/jpg,image/jpeg,image/pjpeg',
        'gif'  => 'image/gif',
        'csv'  => 'text/csv',
        'html' => 'text/html,application/xhtml+xml,*/*',
    ];
    /**
     * 静态资源路径
     */
    protected $resourcePaths = '';
    /**
     * 模板资源路径
     */
    protected $viewPath = '';


    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct()
    {
        $this->resourcePaths = file_build_path(__DIR__, 'view', '');
        $this->viewPath   = file_build_path(__DIR__, 'view', '');
        $config = [
            'view_path' => $this->viewPath,
        ];
        $this->viewConfig =  $config;
    }

    // 初始化
    protected function initialize()
    {
    }



    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        // if (is_array($validate)) {
        //     $v = new Validate();
        //     $v->rule($validate);
        // } else {
        //     if (strpos($validate, '.')) {
        //         // 支持场景
        //         [$validate, $scene] = explode('.', $validate);
        //     }
        //     $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
        //     $v     = new $class();
        //     if (!empty($scene)) {
        //         $v->scene($scene);
        //     }
        // }

        // $v->message($message);

        // // 是否批量验证
        // if ($batch || $this->batchValidate) {
        //     $v->batch(true);
        // }

        // return $v->failException(true)->check($data);
    }
    /**
     * 验证token
     */
    protected function token()
    {
        // $param = $this->request->param();
        // if (!isset($param['token'])) {
        // }
        // $token = false;

        // try {
        //     $true_token = Cache::get($param['token']);
        //     !isset($token['data']->id);
        //     throw new \think\Exception('异常消息', 10006);
        // } catch (\Exception $e) {
        //     throw new \think\Exception('异常消息', 10006);
        // }
    }
}
