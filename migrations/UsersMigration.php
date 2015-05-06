<?php 

namespace Migrations;

use \Core\Migration;

class UsersMigration extends Migration
{

    protected $table = 'users';

    public function up()
    {
        $this->id();
        $this->varchar('email')->required();
        $this->varchar('password')->required();

        $this->create();
    }

    public function down()
    {
        $this->drop();
    }
}
