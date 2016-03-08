<?php

namespace MyModule\Controllers;

class AnotherPage extends AbstractController implements ControllerInterface {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->setSidebarMenu(array(
            array(
                'title' => 'mymodule_settings',
                'url' => $this->createPageUrl(),
                'children' => array(
                    'another_module_page' => $this->createPageUrl('another-page')
                ),
            ),
        ))
            ->generateSidebar();
    }

    /**
     * @param string $page
     * @return string
     */
    public function render($page = '')
    {
        $vars = array();

        return $this
            ->setPage($page)
            ->setVars($vars)
            ->parseView();
    }
}
