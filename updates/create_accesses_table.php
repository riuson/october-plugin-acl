<?php
namespace Riuson\ACL\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAccessesTable extends Migration
{

    public function up()
    {
        Schema::create('riuson_acl_accesses', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riuson_acl_accesses');
    }
}
