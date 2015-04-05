<?php
namespace Riuson\ACL\Classes;

use Auth;
use DB;
use Riuson\ACL\Models\Access as AccessModel;
use Riuson\ACL\Models\Group as GroupModel;
use Riuson\ACL\Models\Permission as PermissionModel;
use Riuson\ACL\Models\PermissionAccessGroup as PermissionAccessGroupModel;
use Riuson\ACL\Models\UserGroup as UserGroupModel;
use Riuson\ACL\Models\Permission;

class Acl
{

    public function test()
    {
        $accessRecord = AccessModel::find(1);
        $user = Auth::getUser();
        $groups = $user->groups;

        $accessID = $accessRecord->getKey();
        $userID = $user->getKey();

        $accessRights = [
            'guest' => [
                'view',
                'out'
            ],
            'user' => [
                'view',
                'delete'
            ]
        ];

        $perms = Acl::permissionsForUserByArray($userID, $accessRights);
        $perms = Acl::permissionsForUserIdAccessId($userID, $accessID);
    }

    /**
     * Returns groups of the specified user.
     * If user not specified, then used current user.
     * If no user active, then asuumed guest.
     *
     * @param string $userID
     * @return array
     */
    public static function userGroups($userID = null)
    {
        if ($userID == null) {
            if (Auth::check()) {
                $user = Auth::getUser();
                $userID = $user->getKey();
            }
        }

        if ($userID == null) {
            $guestGroup = GroupModel::orderBy('level', 'asc')->first();
            return $guestGroup->name;
        }

        $userGroups = DB::table(UserGroupModel::getTableName())->leftJoin(GroupModel::getTableName(), GroupModel::getTableName() . '.' . 'id', '=', UserGroupModel::getTableName() . '.' . 'group_id')
            ->where(UserGroupModel::getTableName() . '.' . 'user_id', '=', $userID)
            ->lists('name');

        return $userGroups;
    }

    public static function accessGrantedByArray($accessRights = null, $requiredPermissions = null)
    {
        if ($requiredPermissions == null || $accessRights == null) {
            return true;
        }

        if (! Auth::check()) {
            return false;
        }

        $user = Auth::getUser();
        $userPermissions = Acl::permissionsForUserByArray($user->getKey(), $accessRights);

        $intersected = array_intersect($requiredPermissions, $userPermissions);

        return (count($intersected) > 0);
    }

    /**
     * Update roles of user by specified in $groupIDs
     *
     * @param integer $userID
     * @param array $groupIDs
     */
    public static function updateRolesForUser($userID, $groupIDs)
    {
        // remove obsolete
        UserGroupModel::whereNotIn('group_id', $groupIDs)->where('user_id', '=', $userID)->delete();

        foreach ($groupIDs as $groupID) {
            UserGroupModel::firstOrCreate([
                'user_id' => $userID,
                'group_id' => $groupID
            ]);
        }
    }

    /**
     * Return array of permission names
     *
     * @param integer $userID
     * @param multitype $accessRights
     *            Source array of groups and permissions
     * @return multitype: Array of permission names
     */
    public static function permissionsForUserByArray($userID, $accessRights)
    {
        /*
         * Access rights format:
         * $access_rights = [
         * ['group_name' => [
         * 'permission_name',
         * 'permission_name',
         * 'permission_name'
         * ],
         * ['group_name' => [
         * 'permission_name',
         * 'permission_name',
         * 'permission_name'
         * ]
         * ];
         */

        /*
         * Select groups of the user
         *
         * select
         * `riuson_acl_groups`.`name`, `riuson_acl_groups`.`level`
         * from `riuson_acl_user_groups`
         * left join `riuson_acl_groups` on `riuson_acl_groups`.`id` = `riuson_acl_user_groups`.`group_id`
         * where
         * `riuson_acl_user_groups`.`user_id` = 1;
         */
        $groups = DB::table(UserGroupModel::getTableName())->leftJoin(GroupModel::getTableName(), GroupModel::getTableName() . '.' . 'id', '=', UserGroupModel::getTableName() . '.' . 'group_id')
            ->where(UserGroupModel::getTableName() . '.' . 'user_id', '=', $userID)
            ->select(GroupModel::getTableName() . '.' . 'name', GroupModel::getTableName() . '.' . 'level')
            ->get();

        $result = array();

        foreach ($groups as $group) {
            if (array_key_exists($group->name, $accessRights)) {
                $result = array_merge($result, $accessRights[$group->name]);
            }
        }

        $result = array_unique($result);

        return $result;
    }

    /**
     * Returns array of permission names
     *
     * @param integer $userID
     *            User ID
     * @param integer $accessID
     *            Id of access record, associated with resource
     * @return array Permission names
     */
    public static function permissionsForUserIdAccessId($userID, $accessID)
    {
        /*
         * select
         * `riuson_acl_permissions`.name
         * from `riuson_acl_user_groups`
         * left join `riuson_acl_permission_access_groups` on `riuson_acl_permission_access_groups`.`group_id` = `riuson_acl_user_groups`.`group_id`
         * left join `riuson_acl_permissions` on `riuson_acl_permissions`.`id` = `riuson_acl_permission_access_groups`.`permission_id`
         * where
         * `riuson_acl_user_groups`.`user_id` = 1
         * and `riuson_acl_permission_access_groups`.`access_id` = 1;
         *
         */
        $result = DB::table(UserGroupModel::getTableName())->leftJoin(PermissionAccessGroupModel::getTableName(), PermissionAccessGroupModel::getTableName() . '.' . 'group_id', '=', UserGroupModel::getTableName() . '.' . 'group_id')
            ->leftJoin(PermissionModel::getTableName(), PermissionModel::getTableName() . '.' . 'id', '=', PermissionAccessGroupModel::getTableName() . '.' . 'permission_id')
            ->where(UserGroupModel::getTableName() . '.' . 'user_id', '=', $userID)
            ->where(PermissionAccessGroupModel::getTableName() . '.' . 'access_id', '=', $accessID)
            ->select(PermissionModel::getTableName() . '.' . 'name')
            ->get();

        return $result;
    }
}
