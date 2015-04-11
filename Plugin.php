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
            // $model->hasMany['groups'] = [
            // 'Riuson\ACL\Models\UserGroup'
            // ];
            $model->belongsToMany['groups'] = [
                'Riuson\ACL\Models\Group',
                'table' => 'riuson_acl_user_groups',
                'other_key' => 'group_id'
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

        \Event::listen('backend.form.extendFields', function ($widget) {
            if (! $widget->getController() instanceof \RainLab\User\Controllers\Users)
                return;
            if (! $widget->model instanceof \RainLab\User\Models\User)
                return;

            $widget->addFields([
                'groups' => [
                    'label' => 'Groups',
                    'commentAbove' => 'Specify which groups this person belongs to.',
                    'tab' => 'Groups',
                    'type' => 'relation'
                ]
            ], 'primary');
        });
    }
}
