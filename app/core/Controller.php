<?php

namespace app\core;

use \App;

class Controller
{
    private $layout = null;
    public $request, $response;
    public function __construct()
    {
        //thuc thi middleware
            Middleware::runBeforeMiddleware();

            //load data share

        ServiceProvider::loadDatashare();

        new Helper('app/helpers');
        $this->request = new Request();
        $this->response = new Response();
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
        $this->response->redirect($uri);
    }

    public function render($viewFile, $data = null, $layout = null)
    {
        if (isset($layout)) {
            $this->setLayout($layout);
        }

        if (!empty(View::$dataShare)){
            $data['share'] = View::$dataShare;
        }
        $data['viewContent'] = $this->getViewContent($viewFile, $data);
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

    /*
        public function renderMultiContent($listViewContentData, $layout = null)
        {
            if (isset($layout)) {
                $this->setLayout($layout);
            }
            $content = [];
            foreach ($listViewContentData as $filePath => $data) {
                $fileArr = explode('/', $filePath);
                $file = end($fileArr);
                $content[$file] = $this->getViewContent($filePath, $data);
                die("loi o function getViewContent");
            }
            echo "<pre>";

            extract($content, EXTR_PREFIX_SAME, 'data');

            if ($this->layout !== null) {
                $layoutPath = __DIR_ROOT__ . '/app/views/' . $this->layout . '.php';
                if (file_exists($layoutPath)) {
                    require_once($layoutPath);
                }
            }
        }
    */
    public function getViewContent($viewFile, $data = null)
    {
        $ctlDir = strtolower(Session::flash('controller'));
        $viewFolder = strtolower(str_replace('Controller', '', $ctlDir));
        $viewPath = __DIR_ROOT__ . '/app/views/' . $viewFolder . '/' . $viewFile . '.php';
        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $data;
        }
        if (file_exists($viewPath)) {
            ob_start();
            require_once($viewPath);
            $contentView = ob_get_contents();
            ob_end_clean();
            return$contentView;
        }
    }

    public static function view($view, $data = null)
    {
        $viewPath = __DIR_ROOT__ . '/app/views/' . $view . '.php';

        if (!empty(View::$dataShare)){
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
