<?php

namespace App\View;

use App\View\ViewError;

class ViewHandler
{
    public static function getBaseContent(): string
    {
        ob_start();
        include viewPath() . 'layouts/main.php';
        return ob_get_clean();
    }

    public static function checkContentReplace($view, $isError = false, $params = [])
    {
        $path = $isError ? viewPath() . 'errors/' : viewPath();

        if (str_contains($view, '.')) {
            $views = explode('.', $view);

            foreach ($views as $view) {
                if (is_dir($path . $view)) {
                    $path .= $view . '/';
                }
            }
            $view = file_exists($path . end($views) . '.php') ? $path . end($views) . '.php' : (ViewError::error('404') . exit());
        } else {
            $view = file_exists($path . $view . '.php') ? $path . $view . '.php' : (ViewError::error('404') . exit());
        }

        extract($params);

        if ($isError) {
            include $view;
            exit();
        }

        ob_start();
        include $view;
        return ob_get_clean();
    }
}
