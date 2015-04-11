<?php
namespace Riuson\ACL;

use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;

/**
 * ACL Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = [
        'RainLab.User'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'ACL',
            'description' => 'Provides simple access control',
            'author' => 'Riuson',
            'icon' => 'icon-leaf'
        ];
    }

    public function boot()
    {
        // extend Rainlab.User model
        UserModel::extend(function ($model) {
            $model->hasMany['groups'] = [
                'Riuson\ACL\Models\UserGroup'
            ];
        });

        // extend Rainlab.User settings
        \Event::listen('backend.menu.extendItems', function ($manager) {
            $manager->addSideMenuItems('RainLab.User', 'user', [
                'groups' => [
                    'label' => 'Groups',
                    'icon' => 'icon-users',
                    'code' => 'groups',
                    'owner' => 'RainLab.User',
                    'url' => \Backend::url('riuson/acl/groups')
                ]
            ]);
        });
    }
}
