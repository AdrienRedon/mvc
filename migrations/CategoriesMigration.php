<?php 

namespace Migrations;

use \Core\Migration;

class CategoriesMigration extends Migration
{

    protected $table = 'categories';

    public function up()
    {
        $this->id();
        $this->varchar('name');

        $this->create();
    }

    public function down()
    {
        $this->drop();
    }
}
