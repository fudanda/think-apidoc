<?php
return [
    'title'     => 'API', # 文档title
    'version'   => '1.0',    # 文档版本
    'copyright' => '',       # 版权信息
    'password'  => '', # 访问密码，为空不需要密码
    'prompt' => '', //温馨提示信息
    'delimiter' => '-', //分割符默认'-',
    'readme' => 'https://github.com/fudanda/think5-apidoc-new',
    'document'  => [
        "explain" => [
            'name' => '说明',
            'list' => [
                '文档' => ['自动生成'],
            ]
        ],
        "code"    => [
            'name' => '返回信息',
            'list' => [
                'code'  => '【0成功】【1失败】【3Token验证失败,重新登录】',
                'msg'   => '提示信息',
                'count' => '分页时数据的总数量',
                'data'  => '数据',
                'jwt'   => 'Token信息,用于验证接口请求',
            ]
        ],
    ],
    // 全局header
    'header' => [],
    // 全局请求参数
    'params'        => [
        'type' => 2
    ],
    // 需要生成文档的类
    'controller'    => [
        [
            'name' => 'v1-(预约:工作人员)', //名称
            'tag' => 'worker',
            'list' => [
                'index\controller\index',
            ],
        ],
        [
            'name' => 'v1-(预约:用户)',
            'tag' => 'user',
            'list' => [
                'user\controller\My',
            ]
        ]
    ],
    // 过滤、不解析的方法名称
    'filter_method' => [
        '_empty'
    ]
];