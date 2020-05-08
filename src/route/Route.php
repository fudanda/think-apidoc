<?php

use think\facade\Route;

Route::get('doc$', function () {
    return redirect('/doc/');
});
Route::get('doc/resource', "Fdd\ApiDoc\controller\Index@resource")->denyExt('php|.htacess');

Route::get('doc/menu', "Fdd\ApiDoc\controller\Index@menu");
Route::any('doc/action', "Fdd\ApiDoc\controller\Index@action");
Route::get('doc/page/welcome', "Fdd\ApiDoc\controller\Page@welcome");
Route::get('doc/', "Fdd\ApiDoc\controller\Index@index");
// Route::any('doc/login$', "\\Fdd\\ApiDoc\\Controller@login");
// Route::any('doc/format_params', "\\Fdd\\ApiDoc\\Controller@format_params");
