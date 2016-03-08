<?php

namespace MyModule\Controllers;

class Template extends Settings implements ControllerInterface {

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
        $vars['cp_page_title'] = lang('');
        $vars['sections'] = array(
            array(
                array(
                    'title' => '',
                    'desc' => '',
                    'fields' => array(
                        '' => array(
                            'type' => 'yes_no',
                            'value' => $this->setting->get(''),
                        )
                    )
                ),
                array(
                    'title' => '',
                    'desc' => '',
                    'fields' => array(
                        '' => array(
                            'type' => 'checkbox',
                            'value' => $this->setting->get(''),
                            'choices' => array(),
                        )
                    )
                ),
                array(
                    'title' => '',
                    'desc' => '',
                    'fields' => array(
                        '' => array(
                            'type' => 'inline_radio',
                            'value' => $this->setting->get(''),
                            'choices' => array(),
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
