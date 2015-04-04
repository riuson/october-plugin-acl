<?php
namespace Riuson\ACL\Models;

use Model;

/**
 * PermissionAccessGroup Model
 */
class PermissionAccessGroup extends Model
{

    /**
     *
     * @var string The database table used by the model.
     */
    public $table = 'riuson_acl_permission_access_groups';

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
    public $hasOne = [
        'group' => 'Riuson\ACL\Models\Group',
        'access' => 'Riuson\ACL\Models\Access',
        'permission' => 'Riuson\ACL\Models\Permission'
    ];

    public $hasMany = [];

    public $belongsTo = [];

    public $belongsToMany = [];

    public $morphTo = [];

    public $morphOne = [];

    public $morphMany = [];

    public $attachOne = [];

    public $attachMany = [];
}