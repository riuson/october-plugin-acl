<?php

return [
    'plugin' => [
        'name' => 'Access Control',
        'description' => 'Простой контроль доступа к страницам с помощью групп'
    ],
    'backend_settings' => [
        'groups_label' => 'Группы',
        'groups_field_comment_above' => 'Укажите, к каким группам относится пользователь.',
    ],
    'backend_group' => [
        'menu_label' => 'Группы',
        'manage_groups' => 'Управление группами',
        'record_name_group' => 'Группа',
        'new_group' => 'Новая группа',
        'create_group' => 'Создать группу',
        'edit_group' => 'Изменить группу',
        'preview_group' => 'Предпросмотр группы',
        'groups' => 'Группы',
        'return_to_list' => 'Вернуться к списку групп',
        'delete_confirm' => 'Вы действительно хотите удалить эту группу?',
        'name' => 'Название',
        'level' => 'Уровень',
        'description' => 'Описание',
    ],
    'access_control' => [
        'name' => 'Контроль доступа',
        'description' => 'Проверка наличия у пользователя указанных групп',
        'required_groups_title' => 'Требуемые группы',
        'required_groups_description' => 'Группы, которым предоставляется доступ к странице',
    ],
];

