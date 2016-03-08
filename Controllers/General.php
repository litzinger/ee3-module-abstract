<?php

namespace MyModule\Controllers;

class General extends Settings implements ControllerInterface {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $page
     * @return string
     */
    public function render($page = '')
    {
        $vars['cp_page_title'] = lang('general_settings');
        $vars['sections'] = array(
            array(
                array(
                    'title' => 'Enable Something',
                    'desc' => 'Setting description goes here',
                    'fields' => array(
                        'enabled' => array(
                            'type' => 'yes_no',
                            'value' => $this->setting->get('enabled'),
                        )
                    )
                ),
            ),
        );

        return $this
            ->setPage($page)
            ->setVars($vars)
            ->handleSubmit()
            ->parseView();
    }
}
