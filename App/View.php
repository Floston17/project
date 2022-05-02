<?php

namespace App;

class View
{
    /**
     * Displays template using required data
     */
    public function display($template, $data = [])
    {
        extract($data);
        $template = __DIR__ . '/Templates/' . $template . '.template.php';
        if (!file_exists($template)) {
            throw new \Exception('Does not exist such file - ' . $template);
        }
        return require $template;
    }

    /**
     * Renders template using output buffer
     */
    public function render($template, $data = [])
    {
        extract($data);
        ob_start();
        require __DIR__ . '/Templates/' . $template . '.template.php';
        $resource = ob_get_contents();
        ob_end_clean();
        return $resource;
    }

    /**
     * Redirects to the path
     */
    public function redirect($path)
    {
        header("Location:/{$path}");
    }
}