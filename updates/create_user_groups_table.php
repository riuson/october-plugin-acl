<?php
namespace Riuson\ACL\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUserGroupsTable extends Migration
{

    public function up()
    {
        Schema::create('riuson_acl_user_groups', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')
                ->unsigned()
                ->index();
            $table->integer('group_id')
                ->unsigned()
                ->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riuson_acl_user_groups');
    }
}
