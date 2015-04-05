<?php
namespace Riuson\ACL\Models;

use Model;

/**
 * UserGroup Model
 */
class UserGroup extends Model
{

    /**
     *
     * @var string The database table used by the model.
     */
    public $table = 'riuson_acl_user_groups';

    public static function getTableName()
    {
        return 'riuson_acl_user_groups';
    }

    /**
     *
     * @var array Guarded fields
     */
    protected $guarded = [
        '*'
    ];

    /**
     *
     * @var array Fillable fields
     */
    protected $fillable = [
        'user_id',
        'group_id'
    ];

    /**
     *
     * @var array Relations
     */
    public $hasOne = [
        'group' => [
            'Riuson\ACL\Models\Group'
        ]
    ];

    public $hasMany = [];

    public $belongsTo = [
        'user' => [
            'RainLab\User\Models\User'
        ]
    ];

    public $belongsToMany = [];

    public $morphTo = [];

    public $morphOne = [];

    public $morphMany = [];

    public $attachOne = [];

    public $attachMany = [];
}