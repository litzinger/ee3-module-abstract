<?php

namespace MyModule\Controllers;

class Settings extends AbstractController {

    /**
     * @var SettingService
     */
    protected $setting;

    /**
     * If you're managing settings within your module extend this class with your controllers.
     * They will inherit the sidebar, and handle form view generation and submission.
     *
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->setting = ee('MyModule:SettingService');

        // Based on some criteria determine which module pages will be hidden from the current user.
        $hideFromMenu = array();
        if (true) {
            $hideFromMenu = array(
                'another_module_page',
            );
        }

        $this->setSidebarMenu(array(
            array(
                'title' => 'mymodule_settings',
                'url' => $this->createPageUrl(),
                'children' => array(
                    'general_settings' => $this->createPageUrl('general'),
                    'another_module_page' => $this->createPageUrl('another-page')
                ),
            ),
        ))
            ->setHiddenInSidebarMenu($hideFromMenu)
            ->generateSidebar()
            ->setSaveCallback(function ($sections) {
                return $this->saveSettings($sections);
            });
    }

    /**
     * Generic method to take an array of fields structured for the form
     * view, check POST for their values, and then save the values in site
     * preferences
     *
     * @param	array	$sections	Array of sections passed to form view
     * @return	bool	Success or failure of saving the settings
     */
    protected function saveSettings($sections)
    {
        $fields = array();

        // Make sure we're getting only the fields we asked for
        foreach ($sections as $settings) {
            foreach ($settings as $setting) {
                foreach ($setting['fields'] as $field_name => $field) {
                    if (isset($field['save_in_config']) && $field['save_in_config'] === FALSE) {
                        continue;
                    }

                    $fields[$field_name] = ee()->input->post($field_name);
                }
            }
        }

        // Make your call to whatever service you're using to save the module's settings.
        // $result = $this->setting->save($fields);

        if (!$result) {
            ee()->load->helper('html_helper');
            ee()->view->set_message('issue', lang('cp_message_issue'), ul($result), TRUE);

            return false;
        }

        return true;
    }
}
