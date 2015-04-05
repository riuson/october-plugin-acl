<?php
namespace Riuson\ACL\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGroupsTable extends Migration
{

    public function up()
    {
        Schema::create('riuson_acl_groups', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('level');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riuson_acl_groups');
    }
}
