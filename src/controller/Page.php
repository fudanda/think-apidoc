<?php

namespace Fdd\ApiDoc\controller;

use think\Request;
use think\facade\View;

class Page
{
    public function welcome(Request $request = null)
    {
        $this->view_path   = file_build_path(__DIR__, '..', 'layuimini-2-onepage', 'page', '');

        $config = [
            'view_path' => $this->view_path,
        ];
        View::config($config);
        View::assign('assetss', '/doc/assetss');
        return View::fetch('welcome');
    }
}
