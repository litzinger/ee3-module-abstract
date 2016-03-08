<?php

namespace MyModule\Controllers;

class Index extends AbstractController implements ControllerInterface {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function render($page = '')
    {
        return 'hi!';
    }
}
