<?php
/**
 * Simple autoloader, so we don't need Composer just for this.
 */
class Autoload
{
    public static function register()
    {
        spl_autoload_register(function (string $class) {
            $file = __DIR__ . '/../app/' .str_replace('\\', '/', $class) . '.php';
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });
    }
}

?>