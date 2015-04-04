<?php
namespace Riuson\ACL\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePermissionAccessGroupsTable extends Migration
{

    public function up()
    {
        Schema::create('riuson_acl_permission_access_groups', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('group_id')
                ->unsigned()
                ->index();
            $table->integer('access_id')
                ->unsigned()
                ->index();
            $table->integer('permission_id')
                ->unsigned()
                ->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riuson_acl_permission_access_groups');
    }
}
