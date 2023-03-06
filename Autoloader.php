<?php

class Autoloader
{

    /**
     * 类库自动加载，写死路径，确保不加载其他文件。
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class)
    {
        $name = $class;

        if (strpos($name, '\\') >= 0) {
            $array = explode('\\', $class);
            $name = array_pop($array);
        }

        $autoload_path = dirname(__FILE__);

        $filename = $autoload_path . "/ms/" . $name . ".php";
        if (is_file($filename)) {
            include $filename;
            return;
        }

        $filename = $autoload_path . "/ms/Request/" . $name . ".php";
        if (is_file($filename)) {
            include $filename;
            return;
        }
    }
}

spl_autoload_register('Autoloader::autoload');
?>