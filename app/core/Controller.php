<?php

namespace app\core;

use \App;

class Controller
{
    private $layout = null;
    public $request, $response;
    public $sKey;

    public function __construct()
    {
        new Helper('app/helpers');
        //thuc thi middleware
        Middleware::runBeforeMiddleware();

        //load data share

        ServiceProvider::loadDatashare();
        $this->request = new Request();
        $this->response = new Response();
        $this->sKey = Session::isInvalid();
        if (isset(Registry::getIntance()->web['layout'])) {
            $this->layout = Registry::getIntance()->web['layout'];
        } else {
            echo "layout khong ton tai<br>";
        }
    }

    public function setLayout($layout)
    {
        return $this->layout = 'layouts/' . $layout;
    }

    /**
     * @param $url
     * @param bool $isEnd
     * @param int $resPonseCode
     */
    public function redirect($uri, $isEnd = true, $resPonseCode = 302)
    {
        $this->response->redirect($uri, $isEnd, $resPonseCode);
    }

    public function render($viewFile, $data = null, $layout = null)
    {
        if (isset($layout)) {
            $this->setLayout($layout);
        }

        if (!empty(View::$dataShare)) {
            $data['share'] = View::$dataShare;
        }
        $data['viewContent'] = $this->getViewContent($viewFile);
        if ($this->layout !== null) {
            $layoutPath = __DIR_ROOT__ . '/app/views/' . $this->layout . '.php';

            ob_start();
            if (file_exists($layoutPath)) {
                require_once($layoutPath);
            }
            $contentView = ob_get_contents();
            ob_end_clean();
            $template = new Template();
            $template->run($contentView, $data);
        }
    }

    public function getViewContent($viewFile)
    {
        $ctlDir = strtolower(Session::flash('controller'));
        $viewFolder = strtolower(str_replace('Controller', '', $ctlDir));
        $viewPath = __DIR_ROOT__ . '/app/views/' . $viewFolder . '/' . $viewFile . '.php';
        if (file_exists($viewPath)) {
            ob_start();
            require_once($viewPath);
            $contentView = ob_get_contents();
            ob_end_clean();
            return $contentView;
        }
    }

    public static function view($view, $data = null)
    {
        $viewPath = __DIR_ROOT__ . '/app/views/' . $view . '.php';

        if (!empty(View::$dataShare)) {
            $data['share'] = View::$dataShare;
        }
        ob_start();
        if (file_exists($viewPath)) {
            require_once($viewPath);
        }
        $contentView = ob_get_contents();
        ob_end_clean();
        $template = new Template();
        $template->run($contentView, $data);
    }

    public function model($model)
    {
        require_once __DIR_ROOT__ . "/app/models/" . $model . ".php";
        return new $model();
    }
}
