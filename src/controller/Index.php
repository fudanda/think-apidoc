<?php

namespace Fdd\ApiDoc\controller;

use think\facade\Config;
use think\Request;
use think\facade\View;
use Fdd\ApiDoc\Build;
use Fdd\ApiDoc\Extractor;
use Fdd\ApiDoc\BaseController;

class Index extends BaseController
{
    # 资源类型

    public function index(Request $request = null)
    {
        View::config($this->viewConfig);
        View::assign('resource', '/doc/resource');
        return View::fetch('index');
    }
    # 解析资源
    public function resource(Request $request = null)
    {
        $path        = str_replace("doc/resource", "", $request->pathinfo());
        $ext         = $request->ext();
        if ($ext) {
            $type    = "text/html";
            $content = file_get_contents($this->resourcePaths . $path);
            if (array_key_exists($ext, $this->mimeType)) {
                $type = $this->mimeType[$ext];
            }
            return response($content, 200, ['Content-Length' => strlen($content)])->contentType($type);
        }
    }
    public function action(Request $request = null, $name)
    {

        if ($request->isGet()) {
            View::config($this->viewConfig);
            return View::fetch('action');
        }
        list($class, $action) = explode("::", $name);
        $method = (new \ReflectionClass($class))->getMethod($action);
        $res = (new Extractor())->parseAction($method);
        $config = Config::get('apiconfig');
        $build = Build::make($config);
        $data = $build->detail($class, $action);


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
