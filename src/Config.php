<?php
return [
    'title'     => 'API', # 文档title
    'version'   => '1.0',    # 文档版本
    'copyright' => '',       # 版权信息
    'password'  => '', # 访问密码，为空不需要密码
    'prompt' => '', //温馨提示信息
    'delimiter' => '-', //分割符默认'-',
    'readme' => 'https://github.com/fudanda/think-apidoc',
    'maintenance' => false, //是否开启文档
    'jwtkey' => 'https://github.com/fudanda/think-apidoc', //jwt密钥
    'document'  => [
        '1' => '说明'
    ],
    "code"    => [
        '0' => '成功',
        '500' => '失败'
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
