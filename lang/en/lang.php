<?php

return [
    'plugin' => [
        'name' => 'Access Control',
        'description' => 'Simple access control to page through user groups'
    ],
    'backend_settings' => [
        'groups_label' => 'Groups',
        'groups_field_comment_above' => 'Specify which groups this person belongs to.',
    ],
    'backend_group' => [
        'menu_label' => 'Groups',
        'manage_groups' => 'Manage Groups',
        'record_name_group' => 'Group',
        'new_group' => 'New Group',
        'create_group' => 'Create Group',
        'edit_group' => 'Edit Group',
        'preview_group' => 'Preview Group',
        'groups' => 'Groups',
        'return_to_list' => 'Return to Groups list',
        'delete_confirm' => 'Do you really want to delete this Group?',
    ],
    'access_control' => [
        'name' => 'Access Control',
        'description' => 'Check for user have permissions',
        'required_groups_title' => 'Required groups',
        'required_groups_description' => 'Groups, allowed to access to page',
    ],
];
