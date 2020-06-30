<?php

namespace Mix\FastRoute\Helper;

/**
 * Class ConfigHelper
 * @package Mix\FastRoute\Helper
 */
class ConfigHelper
{

    /**
     * 遍历配置目录，返回全部配置
     * @param string $path
     * @return callable[]
     */
    public static function each(string $path): array
    {
        if (is_file($path)) {
            return [include $path];
        } else {
            $dir = $path;
        }
        $dh = @opendir($dir);
        if (!$dh) {
            throw new \RuntimeException(sprintf('Invalid path: %s', $path));
        }
        $files = [];
        while (false !== ($file = readdir($dh))) {
            if (($file != '.') && ($file != '..')) {
                $full = $dir . '/' . $file;
                $info = pathinfo($file);
                $ext  = $info['extension'] ?? '';
                if (is_file($full) && $ext == 'php') {
                    $files[] = $full;
                }
            }
        }
        closedir($dh);
        asort($files);
        $config = [];
        foreach ($files as $file) {
            array_push($config, include $file);
        }
        return $config;
    }

}
