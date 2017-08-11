<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/14
 * Time: 下午9:57
 */

use Illuminate\Support\Str;

if (! function_exists('admin_view')) {

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string $view
     * @param  array  $data
     * @param  array  $mergeData
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function admin_view($view = null, $data = [], $mergeData = [])
    {
        $factory = view();

        if (func_num_args() === 0) {
            return $factory;
        }

        if (Str::contains($view, '::')) {
            return $factory->make($view, $data, $mergeData);
        }

        return $factory->make('admin::' . $view, $data, $mergeData);
    }
}

if (! function_exists('option')) {

    /**
     * Get / set the specified option value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param array|string $key
     * @param mixed        $default
     * @param integer      $user_id
     *
     * @return mixed
     */
    function option($key = null, $default = null, $user_id = 0)
    {

        $option = app('option.repository');

        if (is_null($key)) {
            return $option;
        }

        if (is_array($key)) {

            switch (count($key)) {
                case 2:
                    return $option->set($key[0], $key[1]);

                case 3:
                    return $option->set($key[0], $key[1], $key[2]);

                default:
                    return;
            }
        }

        return $option->get($key, $default, $user_id);
    }
}

if (! function_exists('slug_name')) {

    /**
     * 生成缩略名
     *
     * @param string  $str       需要生成缩略名的字符串
     * @param string  $default   默认的缩略名
     * @param integer $maxLength 缩略名最大长度
     *
     * @return null|string
     */
    function slug_name($str, $default = null, $maxLength = 128)
    {
        $str = trim($str);

        if (! mb_strlen($str)) {
            return $default;
        }

        mb_regex_encoding('UTF-8');
        mb_ereg_search_init($str, "[\w" . preg_quote('_-') . "]+");
        $result = mb_ereg_search();
        $return = '';

        if ($result) {
            $regs = mb_ereg_search_getregs();
            $pos  = 0;
            do {
                $return .= ($pos > 0 ? '-' : '') . $regs[0];
                $pos++;
            } while ($regs = mb_ereg_search_regs());
        }

        $str = $return;

        $str = trim($str, '-_');
        $str = (! mb_strlen($str)) ? $default : $str;

        return mb_substr($str, 0, $maxLength);
    }
}

if (function_exists('fix_html')) {

    /**
     * 自闭合 html 修复函数
     * 使用方法:
     * <code>
     * $input = '这是一段被截断的 html 文本 <a href="#"';
     * echo fix_html($input);
     * // output: 这是一段被截断的html文本
     * </code>
     *
     * @param string $string 需要修复处理的字符串
     *
     * @return string
     */
    function fix_html($string) {
        // 关闭自闭合标签
        $startPos = strrpos($string, "<");

        if (false == $startPos) {
            return $string;
        }

        $trimString = substr($string, $startPos);

        if (false === strpos($trimString, ">")) {
            $string = substr($string, 0, $startPos);
        }

        // 非自闭合 html 标签列表
        preg_match_all("/<([_0-9a-zA-Z-\:]+)\s*([^>]*)>/is", $string, $startTags);
        preg_match_all("/<\/([_0-9a-zA-Z-\:]+)>/is", $string, $closeTags);

        if (! empty($startTags[1]) && is_array($startTags[1])) {
            krsort($startTags[1]);
            $closeTagsIsArray = is_array($closeTags[1]);

            foreach ($startTags[1] as $key => $tag) {
                $attrLength = strlen($startTags[2][$key]);
                if ($attrLength > 0 && "/" == trim($startTags[2][$key][$attrLength - 1])) {
                    continue;
                }
                if (! empty($closeTags[1]) && $closeTagsIsArray) {
                    if (false !== ($index = array_search($tag, $closeTags[1]))) {
                        unset($closeTags[1][$index]);
                        continue;
                    }
                }

                $string .= "</{$tag}>";
            }
        }

        return preg_replace("/\<br\s*\/\>\s*\<\/p\>/is", '</p>', $string);
    }
}