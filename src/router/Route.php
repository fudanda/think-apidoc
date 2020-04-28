<?php

use think\facade\Route;

Route::get('doc$', function () {
    return redirect('/doc/document?name=explain');
});
Route::get('doc/assets', "\\Fdd\\ApiDoc\\DocController@assets", ['deny_ext' => 'php|.htacess']);
Route::get('doc/assetss', "\\Fdd\\ApiDoc\\DocController@assetss", ['deny_ext' => 'php|.htacess']);

Route::get('doc/module', "\\Fdd\\ApiDoc\\Controller@module");
Route::get('doc/action', "\\Fdd\\ApiDoc\\Controller@action");
Route::get('doc/document', "\\Fdd\\ApiDoc\\\Controller@document");
Route::any('doc/login$', "\\Fdd\\ApiDoc\\Controller@login");
Route::any('doc/format_params', "\\Fdd\\ApiDoc\\Controller@format_params");
