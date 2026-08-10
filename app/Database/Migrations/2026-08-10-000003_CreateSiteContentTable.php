<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiteContentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'section'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'key'        => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'value'      => ['type' => 'TEXT', 'null' => true],
            'type'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => false, 'default' => 'text'],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => false],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug', 'section', 'key');
        $this->forge->addKey('slug');
        $this->forge->addKey('section');
        $this->forge->createTable('site_content');
    }

    public function down()
    {
        $this->forge->dropTable('site_content');
    }
}
