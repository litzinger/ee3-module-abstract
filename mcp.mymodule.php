<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

use MyModule\Controllers\ControllerInterface;

class MyModule_mcp {

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    public function index()
    {
        return $this->runController('index');
    }

    public function general()
    {
        return $this->runController('general');
    }

    public function anotherPage()
    {
        return $this->runController('another-page');
    }

    /**
     * @param $page
     * @return string
     */
    private function runController($page)
    {
        $this->authorize();

        $className = str_replace(' ', '', ucwords(str_replace('-', ' ', $page)));
        $className = 'MyModule\\Controllers\\'.$className;
        /** @var ControllerInterface $controller */
        $controller = new $className();

        return $controller->render($page);
    }

    /**
     * See if the current user can access the requested module page
     *
     * @return boolean
     */
    private function authorize()
    {
        return true;
    }
}
