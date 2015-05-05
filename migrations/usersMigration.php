<?php 

namespace Migrations;

use \Core\Migration;

class UsersMigration extends Migration
{

    protected $table = 'users';

    public function up()
    {
        $this->id();
        $this->varchar('email');
        $this->varchar('password');

        $this->create();
    }

    public function down()
    {
        $this->drop();
    }
}