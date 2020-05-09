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
        return View::fetch('welcome');
    }
}
