<?php

namespace jesterone\mvccore;

class View
{
    public string $title = '';

    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
//        include_once Application::$ROOT_DIR . "/Views/$view.php";
    }

    public function renderContent($viewConent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewConent, $layoutContent);
//        include_once Application::$ROOT_DIR . "/Views/$view.php";
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/Views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value; // if $key = 'name' then we receive $name = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/Views/$view.php";
        return ob_get_clean();

    }
}