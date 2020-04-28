<?php


namespace Fdd\ApiDoc;

class Service extends \think\Service
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . DIRECTORY_SEPARATOR . 'route' . DIRECTORY_SEPARATOR . 'Route.php');
    }
}
