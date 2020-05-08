<?php

namespace app\index\controller;



/**
 * @ApiTitle   模块名称
 * @ApiDesc    我是模块名称
 * Class Index
 * @package app\api\controller\v1
 */
class Index
{
    /**
     *@ApiTitle(配置信息)
     *@ApiDesc(获取配置信息)
     *@ApiVersion(V1)
     *@ApiAuthor(fuqiang)
     *@ApiMethod(POST)
     *@ApiUrl(index/demo)
     *@ApiParam(int-option_id-消息类型id-'')
     *@ApiParam(string-page-页码-1)
     *@ApiParam(file-image-页码-)
     *@ApiParam(array-book-页码-)
     *@ApiReturn(int-code-状态-1)
     *@ApiReturn(int-page-数据总数量-)
     *@ApiReturn(string-msg-返回信息-)
     *@ApiLog(2019/11/19-修改log)
     *@ApiLog(2019/11/20-修改短信)
     */
    public function demo()
    {
        return [];
    }
}
