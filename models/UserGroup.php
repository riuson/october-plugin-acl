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

    public $hasMany = [];

    public $belongsTo = [];

    public $belongsToMany = [];

    public $morphTo = [];

    public $morphOne = [];

    public $morphMany = [];

    public $attachOne = [];

    public $attachMany = [];
}