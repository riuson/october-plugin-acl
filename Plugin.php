<?php

namespace Riuson\ACL;

use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;

/**
 * ACL Plugin Information File
 */
class Plugin extends PluginBase
{

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

}
