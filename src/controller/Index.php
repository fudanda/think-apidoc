<?php

namespace Fdd\ApiDoc\controller;

use think\facade\Config;
use think\Request;
use think\facade\View;
use Fdd\ApiDoc\Build;
use Fdd\ApiDoc\Extractor;

class Index
{
    # 资源类型
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
    public function index(Request $request = null)
    {

        $this->assets_paths = file_build_path(__DIR__, '..', 'layuimini-2-onepage', '');
        $this->view_path   = file_build_path(__DIR__, '..', 'layuimini-2-onepage', '');

        $config = [
            'view_path' => $this->view_path,
        ];
        View::config($config);
        View::assign('assetss', '/doc/assetss');
        return View::fetch('index');
    }
    # 解析资源
    public function assetss(Request $request = null)
    {
        $assets_path = file_build_path(__DIR__, '..', 'layuimini-2-onepage', '');
        $path        = str_replace("doc/assetss", "", $request->pathinfo());
        $ext         = $request->ext();
        if ($ext) {
            $type    = "text/html";
            $content = file_get_contents($assets_path . $path);
            if (array_key_exists($ext, $this->mimeType)) {
                $type = $this->mimeType[$ext];
            }
            return response($content, 200, ['Content-Length' => strlen($content)])->contentType($type);
        }
    }
    public function action(Request $request = null, $name)
    {

        if ($request->isGet()) {
            $this->view_path   = file_build_path(__DIR__, '..', 'layuimini-2-onepage', '');
            $config = [
                'view_path' => $this->view_path,
            ];
            View::config($config);
            View::assign('assetss', '/doc/assetss');
            return View::fetch('action');
        }
        list($class, $action) = explode("::", $name);
        $method = (new \ReflectionClass($class))->getMethod($action);
        $res = (new Extractor())->parseAction($method);
        $config = Config::get('apiconfig');
        $build = Build::make($config);
        $data = $build->detail($class, $action);

        // var_dump($data);

        $jsondata = [
            'code' => 200,
            'msg' => '成功',
            'data' => $data
        ];
        return json($jsondata);
    }


    public function menu()
    {
        $config = Config::get('apiconfig');
        $build = Build::make($config);
        $menu = $build->formattingMenu($build->list());
        return json($menu);
    }
}
