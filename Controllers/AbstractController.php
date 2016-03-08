<?php

namespace MyModule\Controllers;

use Closure;
use EllisLab\ExpressionEngine\Service\Sidebar\Sidebar;
use EllisLab\ExpressionEngine\Service\View\View;

abstract class AbstractController {

    /**
     * @var array
     */
    private $vars = array();

    /**
     * @var string
     */
    private $baseUrl = 'addons/settings';

    /**
     * @var string
     */
    private $addonName = '';

    /**
     * @var string
     */
    private $page = '';

    /**
     * @var array
     */
    private $sidebarMenu = array();

    /**
     * @var array
     */
    private $hiddenInSidebarMenu = array();

    /**
     * @var Closure
     */
    private $saveCallback;

    /**
     * Constructor
     */
    function __construct()
    {
        ee()->lang->loadfile('settings');
        ee()->load->library('form_validation');

        // Determine the base url. 3rd segment will
        // always be the name of the add-on.
        if (isset(ee()->uri->rsegments[3])) {
            $this->baseUrl .= '/'. ee()->uri->rsegments[3];
            $this->addonName = ee()->uri->rsegments[3];
        }

        ee()->view->header = array(
            'title' => lang(sprintf('%s_settings', $this->addonName)),
        );

        $this->vars = array(
            'base_url' => $this->createPageUrl(),
            'save_btn_text' => 'btn_save_settings',
            'save_btn_text_working' => 'btn_saving',
        );
    }

    /**
     * @return string
     */
    protected function moduleHomeUrl()
    {
        return $this->createPageUrl();
    }

    /**
     * @param string $page
     * @return string
     */
    protected function createPageUrl($page = '')
    {
        return ee('CP/URL')->make($this->baseUrl . '/' . $page);
    }

    /**
     * @return string
     */
    protected function currentPageUrl()
    {
        return $this->createPageUrl($this->getPage());
    }

    /**
     * @return $this
     */
    protected function generateSidebar()
    {
        /** @var Sidebar $sidebar */
        $sidebar = ee('CP/Sidebar')->make();

        $hiddenInSidebarMenu = $this->getHiddenInSidebarMenu();

        foreach ($this->getSidebarMenu() as $section) {
            $list = $sidebar->addHeader(lang($section['title']), $section['url'])->addBasicList();

            foreach ($section['children'] as $langKey => $url) {
                if (in_array($langKey, $hiddenInSidebarMenu)) {
                    continue;
                }

                $list->addItem(lang($langKey), $url);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function handleSubmit()
    {
        $vars = $this->getVars();
        ee()->form_validation->validateNonTextInputs($vars['sections']);

        if (ee()->form_validation->run() !== false)
        {
            $callback = $this->getSaveCallback();
            if ($callback($vars['sections'])) {
                $alert = ee('CP/Alert');
                $alert->makeInline('shared-form')
                    ->asSuccess()
                    ->withTitle(lang('preferences_updated'))
                    ->defer();

                ee()->functions->redirect($this->currentPageUrl());
            }

            ee()->functions->redirect($this->moduleHomeUrl());
        }
        elseif (ee()->form_validation->errors_exist())
        {
            $errors = array();
            foreach (ee()->form_validation->_error_array as $key => $value) {
                $errors[] = $key .': '. $value;
            }

            $alert = ee('CP/Alert');
            $alert->makeInline('shared-form')
                ->asIssue()
                ->withTitle(lang('settings_save_error'))
                ->addToBody($errors)
                ->defer();

            ee()->functions->redirect($this->currentPageUrl());
        }

        return $this;
    }

    /**
     * @param string $view
     * @return string
     */
    protected function parseView($view = 'settings')
    {
        $viewFile = sprintf('%s:%s', $this->addonName, $view);
        /** @var View $view */
        $view = ee('View')->make($viewFile);
        return $view->render($this->getVars());
    }

    /**
     * @param string $page
     * @return $this
     */
    protected function setPage($page = '')
    {
        $this->page = $page;
        // Also set the vars that will be passed used in the view's form
        $this->vars['base_url'] = $this->createPageUrl($page);

        return $this;
    }

    protected function getPage()
    {
        return $this->page;
    }

    /**
     * @param $vars
     * @return $this
     */
    protected function setVars($vars)
    {
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

    /**
     * @return array
     */
    protected function getVars()
    {
        return $this->vars;
    }

    /**
     * @return Closure
     */
    public function getSaveCallback()
    {
        return $this->saveCallback;
    }

    /**
     * @param Closure $saveCallback
     * @return $this
     */
    public function setSaveCallback($saveCallback)
    {
        $this->saveCallback = $saveCallback;

        return $this;
    }

    /**
     * @return array
     */
    public function getSidebarMenu()
    {
        return $this->sidebarMenu;
    }

    /**
     * @param array $sidebarMenu
     * @return $this
     */
    public function setSidebarMenu($sidebarMenu)
    {
        $this->sidebarMenu = $sidebarMenu;

        return $this;
    }

    /**
     * @return array
     */
    public function getHiddenInSidebarMenu()
    {
        return $this->hiddenInSidebarMenu;
    }

    /**
     * @param array $hiddenInSidebarMenu
     * @return $this
     */
    public function setHiddenInSidebarMenu($hiddenInSidebarMenu)
    {
        $this->hiddenInSidebarMenu = $hiddenInSidebarMenu;

        return $this;
    }
}
