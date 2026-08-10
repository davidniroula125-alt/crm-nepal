<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRepliedAtToComplaints extends Migration
{
    public function up()
    {
        $this->forge->addColumn('complaints', [
            'replied_at' => ['type' => 'TIMESTAMP', 'null' => true, 'after' => 'admin_reply'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('complaints', 'replied_at');
    }
}
