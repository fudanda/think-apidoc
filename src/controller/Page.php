<?php

namespace Fdd\ApiDoc\controller;

use think\Request;
use think\facade\View;
use Fdd\ApiDoc\BaseController;

class Page extends BaseController
{
    public function welcome()
    {
        View::config($this->viewConfig);
        View::assign('resource', '/doc/resource');

        $config = $this->apiConfig;
        View::assign('code', $config['code']);
        View::assign('document', $config['document']);
        return View::fetch('welcome');
    }
}
