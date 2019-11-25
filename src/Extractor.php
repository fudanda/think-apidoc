<?php

namespace FuDanDa\ApiDoc;

use think\facade\Config;

class Extractor
{
    /**
     * 解析类
     * @param $object
     *
     * @return array
     */
    public  function parseClass($array)
    {
        return $this->formatComment($this->paeseDocComment($array));
    }
    /**
     * @param \ReflectionClass $object
     *
     * @return array|bool
     */
    public function parseAction($object)
    {
        $docComment = $this->getDocComment($object);
        $comment = $this->formatComment($this->paeseDocComment($docComment));
        mayBe(!isset($comment['ApiUrl']), !$comment['ApiUrl'])
            && $comment['ApiUrl'] = $this->buildUrl($object);
        mayBe(!isset($comment['ApiMethod']), !$comment['ApiMethod'])
            &&  $comment['ApiMethod'] = 'GET';
        mayBe(!isset($comment['ApiTitle']), !$comment['ApiTitle'])
            &&  $comment['ApiTitle'] = '暂无';
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
     * 解析字符串
     *
     * @param [string] $content
     * @return array
     */
    private static function parseArgs($content)
    {
        $doc = new Doc((array) Config::pull('api_config'));
        $delimiter = $doc->__get('delimiter');
        empty($delimiter) && $delimiter = '-';
        $content = explode($delimiter, $content);
        return $content;
    }
    /**
     * 格式化注释
     *
     * @param \ReflectionClass $object
     * @return array
     */
    public function formatComment($array)
    {
        // $docComment = $this->getDocComment($object);
        // $annotationsArr = $this->paeseDocComment($docComment);
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
                return url($data[0][0], '', false, true);
            },
            'ApiParam'  => function ($data) {
                foreach ($data as $key => $value) {
                    $new_data[$key] = [
                        'type'    => $data[$key][0],
                        'name'    => $data[$key][1],
                        'desc' => $data[$key][2],
                        'default'    => $data[$key][3],
                    ];
                }
                return $new_data;
            },
            'ApiReturn'  => function ($data) {
                foreach ($data as $key => $value) {
                    $new_data[$key] = [
                        'type'    => $data[$key][0],
                        'name'    => $data[$key][1],
                        'desc' => $data[$key][2],
                        'default'    => $data[$key][3],
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
        foreach ($array as $key => $value) {
            if (array_key_exists($key, $config)) {
                $item = call_user_func($config[$key], $value);
                $newArr[$key] = $item;
            }
        }
        return $newArr;
    }
    /**
     * 解析文档注释
     *
     * @param Type $var
     * @return array
     */
    public function paeseDocComment($array)
    {

        $annotations = array();
        if (preg_match_all('/@(?<name>[A-Za-z_-]+)[\s\t]*\((?<args>(?:(?!\)).)*)\)\r?/s', $array, $matches)) {
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
    public function getDocCommentArr($object)
    {
        $docComment = $this->getDocComment($object);
        $comment = $this->formatComment($this->paeseDocComment($docComment));
        return $comment;
    }
    /**
     * 获取文档注释
     *
     * @return void
     */
    public function getDocComment($object)
    {
        return $object->getDocComment();
    }
}