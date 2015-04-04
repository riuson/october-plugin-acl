<?php
namespace Riuson\ACL\Models;

use Model;

/**
 * Access Model
 */
class Access extends Model
{

    /**
     *
     * @var string The database table used by the model.
     */
    public $table = 'riuson_acl_accesses';

    public static function getTableName()
    {
        return 'riuson_acl_accesses';
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
    protected $fillable = [];

    /**
     *
     * @var array Relations
     */
    public $hasOne = [];

    public $hasMany = [
        'permissions' => 'Riuson\ACL\Models\PermissionAccessGroup'
    ];

    public $belongsTo = [];

    public $belongsToMany = [];

    public $morphTo = [];

    public $morphOne = [];

    public $morphMany = [];

    public $attachOne = [];

    public $attachMany = [];
}