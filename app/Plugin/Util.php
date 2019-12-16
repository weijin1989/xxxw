<?php

namespace App\Plugin;
/**
 * Created by PhpStorm.
 * User: weijin
 * Date: 2016/6/22
 * Time: 10:28
 */
class Util
{
    /**
     *
     * ѭ������Ŀ¼
     * @param string $dir			Ŀ¼��·��,���磺d:\123\123
     * @param unknown_type $mode
     */
    public static function mkDir($dir, $mode = 0777)
    {
        $dir = self::dir_path($dir);
        if (is_dir($dir) || @mkdir($dir,$mode)) return true;
        if (!self::mkDir(dirname($dir),$mode)) return false;
        return @mkdir($dir,$mode);
    }

    /**
     *
     * ת��Ŀ¼��ַ �� \\ת��Ϊ /
     * @param string $path
     * @return string
     */
    public static function dir_path($path)
    {
        $path = str_replace('\\', '/', $path);
        if (substr($path, -1) != '/') $path = $path . '/';
        return $path;
    }
}