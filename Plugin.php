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
            'name' => 'riuson.acl::lang.plugin.name',
            'description' => 'riuson.acl::lang.plugin.description',
            'author' => 'Riuson',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'Riuson\ACL\Components\AccessControl' => 'accessControl',
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
                    'label' => 'riuson.acl::lang.backend_settings.groups_label',
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
                    'label' => 'riuson.acl::lang.backend_settings.groups_label',
                    'commentAbove' => 'riuson.acl::lang.backend_settings.groups_field_comment_above',
                    'tab' => 'riuson.acl::lang.backend_settings.groups_label',
                    'type' => 'relation'
                ]
            ], 'primary');
        });
    }
}
