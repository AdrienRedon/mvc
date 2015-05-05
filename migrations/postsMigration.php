<?php 

namespace Migrations;

use \Core\Migration;

class PostsMigration extends Migration
{

    protected $table = 'posts';

    public function up()
    {
        $this->id();
        $this->varchar('name');
        $this->text('content');
        $this->integer('user_id');

        $this->create();
    }

    public function down()
    {
        $this->drop();
    }
}