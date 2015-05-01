<?php
namespace Riuson\ACL\Components;

use Cms\Classes\ComponentBase;

class AccessControl extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'riuson.acl::lang.access_control.name',
            'description' => 'riuson.acl::lang.access_control.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'requiredGroups' => [
                'title' => 'riuson.acl::lang.access_control.required_groups_title',
                'description' => 'riuson.acl::lang.access_control.required_groups_description',
                'default' => '',
                'type' => 'string'
            ],
            'redirect' => [
                'title' => 'rainlab.user::lang.session.redirect_title',
                'description' => 'rainlab.user::lang.session.redirect_desc',
                'type' => 'dropdown',
                'default' => ''
            ]
        ];
    }

    public function getRedirectOptions()
    {
        return [
            '' => '- none -'
        ] + \Cms\Classes\Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function init()
    {
        if (! $this->accessGranted()) {
            $redirectUrl = $this->controller->pageUrl($this->property('redirect'));
            return \Redirect::guest($redirectUrl);
        }
    }

    public function onRun()
    {
        if (! $this->accessGranted()) {
            $redirectUrl = $this->controller->pageUrl($this->property('redirect'));
            return \Redirect::guest($redirectUrl);
        }
    }

    private function accessGranted()
    {
        $requiredGroups = $this->property('requiredGroups');

        return \Riuson\ACL\Classes\Acl::isUserInGroups($requiredGroups);
    }
}