<?php

namespace MyModule\Controllers;

interface ControllerInterface
{
    /**
     * @param $page
     * @return string
     */
    public function render($page);
}
