<?php

namespace app\index\controller;

use think\Controller;

/**
 * @ApiTitle   模块名称
 * @ApiDesc    我是模块名称
 * Class Index
 * @package app\api\controller\v1
 */
class Index extends Controller
{
    /**
     *@ApiTitle(新闻列表)
     *@ApiDesc(获取厂区新闻列表)
     *@ApiAuthor(fuqiang)
     *@ApiMethod(GET)
     *@ApiUrl(index/demo/index)
     *@ApiParam(int-option_id-消息类型id-'')
     *@ApiParam(string-page-页码-1)
     *@ApiReturn(int-code-状态-1)
     *@ApiReturn(int-page-数据总数量-)
     *@ApiReturn(string-msg-返回信息-)
     *@ApiLog(2019/11/19-修改log)
     *@ApiLog(2019/11/20-修改短信)
     */
    public function index()
    {
        return [];
    }
}