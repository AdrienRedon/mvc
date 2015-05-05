<?php 

namespace Migrations;

use \Core\Migration;

class PagesMigration extends Migration
{

    protected $table = 'pages';

    public function up()
    {
        $this->id();
        $this->varchar('name');
        $this->text('content');

        $this->create();
    }

    public function down()
    {
        $this->drop();
    }
}