<?php
namespace Riuson\ACL\Classes;

use Auth;
use DB;
use Riuson\ACL\Models\Group as GroupModel;
use Riuson\ACL\Models\UserGroup as UserGroupModel;

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
     * Returns true, if user is in one of required groups
     *
     * @param array $requiredGroups
     * @param integer $userID
     * @return boolean
     */
    public static function isUserInGroups($requiredGroups = null, $userID = null)
    {
        if (empty($requiredGroups)) {
            return true;
        }

        $userGroups = Acl::userGroups($userID);

        if (is_string($requiredGroups)) {
            $requiredGroups = array_map('trim', explode(',', $requiredGroups));
        }

        $intersection = array_intersect($userGroups, $requiredGroups);

        if (empty($intersection)) {
            return false;
        }

        return (count($intersection) > 0);
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
            return [
                $guestGroup->name
            ];
        }

        $userGroups = DB::table(UserGroupModel::getTableName())->leftJoin(GroupModel::getTableName(), GroupModel::getTableName() . '.' . 'id', '=', UserGroupModel::getTableName() . '.' . 'group_id')
            ->where(UserGroupModel::getTableName() . '.' . 'user_id', '=', $userID)
            ->lists('name');

        return $userGroups;
    }

    /**
     * Update groups of $userID by specified in array $groupIDs
     *
     * @param integer $userID
     * @param array $groupIDs
     */
    public static function updateGroupsForUser($userID, $groupIDs)
    {
        if ($userID != null) {
            // add user group
            $userGroup = GroupModel::whereName('user')->first();

            if (! empty($userGroup)) {
                if (! in_array($userGroup->getKey(), $groupIDs)) {
                    array_push($groupIDs, $userGroup->getKey());
                }
            }

            // remove obsolete
            UserGroupModel::whereNotIn('group_id', $groupIDs)->where('user_id', '=', $userID)->delete();

            // add new
            foreach ($groupIDs as $groupID) {
                UserGroupModel::firstOrCreate([
                    'user_id' => $userID,
                    'group_id' => $groupID
                ]);
            }
        }
    }
}
