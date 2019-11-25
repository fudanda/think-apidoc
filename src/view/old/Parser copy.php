<?php

/** .-------------------------------------------------------------------
 * | Author: OkCoder <1046512080@qq.com>
 * | Git: https://www.gitee.com/okcoder
 * | Copyright (c) 2012-2019, www.i5920.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace OkCoder\ApiDoc;


class Parser
{
    /**
     * 获取文档注释
     *
     * @return void
     */
    public function getDocComment($object)
    {
        return $object->getDocComment();
    }
    /**
     * 解析文档注释
     *
     * @param Type $var
     * @return void
     */
    public function paeseDocComment($object)
    {
        $docComment = $this->getDocComment($object);
        $annotations = array();
        if (preg_match_all('/@(?<name>[A-Za-z_-]+)[\s\t]*\((?<args>(?:(?!\)).)*)\)\r?/s', $docComment, $matches)) {
            $numMatches = count($matches[0]);
            for ($i = 0; $i < $numMatches; ++$i) {
                $value = [];
                if (isset($matches['args'][$i])) {
                    $argsParts = trim($matches['args'][$i]);
                    $name      = $matches['name'][$i];
                    $value     = self::parseArgs($argsParts);
                } else { }
                $annotations[$name][] = $value;
            }
        }
        return $annotations;
    }
    public function formatComment($object)
    {
        $annotationsArr = $this->paeseDocComment($object);
        $config = [
            'ApiTitle'   => function ($data) {
                return $data[0][0];
            },
            'ApiDesc'    => function ($data) {
                return $data[0][0];
            },
            'ApiVersion' => function ($data) {
                return $data[0][0];
            },
            'ApiMethod'  => function ($data) {
                return $data[0][0];
            },
            'ApiAuthor'  => function ($data) {
                return $data[0][0];
            },
            'ApiUrl'  => function ($data) {
                return $data[0][0];
            },
            'ApiParam'  => function ($data) {
                foreach ($data as $key => $value) {
                    $new_data[$key] = [
                        'type'    => $data[$key][0],
                        'name'    => $data[$key][1],
                        'default' => $data[$key][2],
                        'desc'    => $data[$key][3],
                    ];
                }
                return $new_data;
            },
            'ApiReturn'  => function ($data) {
                foreach ($data as $key => $value) {
                    $new_data[$key] = [
                        'type'    => $data[$key][0],
                        'name'    => $data[$key][1],
                        'default' => $data[$key][2],
                        'desc'    => $data[$key][3],
                    ];
                }
                return $new_data;
            },
            'ApiLog'  => function ($data) {
                foreach ($data as $key => $value) {
                    $new_data[$key] = [
                        'title'    => $data[$key][0],
                        'desc'    => $data[$key][1],
                    ];
                }
                return $new_data;
            },
        ];
        $newArr = [];
        foreach ($annotationsArr as $key => $value) {
            if (array_key_exists($key, $config)) {
                $item = call_user_func($config[$key], $value);
                $newArr[$key] = $item;
            }
        }
        return $newArr;
    }
    private static function parseArgs($content)
    {
        $content = explode(',', $content);
        return $content;
    }
    /**
     * 解析类
     * @param $object
     *
     * @return array
     */
    public function parse_class($object)
    {
        return $this->parseCommentArray($this->comment2Array($object));
    }
    /**
     * @param \ReflectionClass $object
     *
     * @return array|bool
     */
    public function parse_action($object)
    {

        $comment = $this->parseCommentArray($this->comment2Array($object));

        if (!isset($comment['url']) || !$comment['url']) {
            $comment['url'] = $this->buildUrl($object);
        }
        if (!isset($comment['method']) || !$comment['method']) {
            $comment['method'] = 'GET';
        }
        $comment['href'] = "{$object->class}::{$object->name}";
        return $comment;
    }
    /**
     * @param \ReflectionClass $object
     *
     * @return mixed
     */
    private function buildUrl($object)
    {
        $_arr = explode('\\', strtolower($object->class));
        if (count($_arr) === 5) {
            $url = url($_arr[1] . '/' . $_arr[3] . '.' . $_arr[4] . '/' . $object->name, '', '', true);
        } else {
            $url = url($_arr[1] . '/' . $_arr[3] . '/' . $object->name, '', '', true);
        }
        return $url;
    }
    /**
     * 注释字符串转数组
     *
     * @param string $comment
     *
     * @return array
     */
    private function comment2Array($comment = '')
    {
        // 多空格转换成单空格
        $comment = preg_replace('/[ ]+/', ' ', $comment);
        preg_match_all('/\*[\s+]?@(.*?)[\n|\r]/is', $comment, $matches);
        $arr = [];
        foreach ($matches[1] as $key => $match) {
            $arr[$key] = explode(' ', $match);
        }
        return $arr;
    }
    /**
     * 解析注释数组
     *
     * @param array $array
     *
     * @return array
     */
    private function parseCommentArray(array $array = [])
    {
        $newArr = [];
        foreach ($array as $item) {
            switch (strtolower($item[0])) {
                case 'title':
                case 'desc':
                case 'version':
                case 'update':
                case 'author':
                default:
                    $newArr[$item[0]] = isset($item[1]) ? $item[1] : '-';
                    break;
                case 'url':
                    @eval('$newArr["url"]=(' . $item[1] . ');');
                    break;
                case 'param':
                case 'return':
                    $newArr[$item[0]][] = [
                        'type' => $item[1],
                        'name' => preg_replace('/\$/i', '', $item[2]),
                        'default' => isset($item[3]) ? $item[3] : '-',
                        'desc' => isset($item[4]) ? $item[4] : '-'
                    ];
                    break;
                case 'log':
                    $newArr[$item[0]][] = [
                        'date' => isset($item[1]) ? $item[1] : '-',
                        'desc' => $item[2],
                    ];
                    break;
            }
        }
        // dump($newArr);
        return $newArr;
    }
}