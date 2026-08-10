<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFollowUpsTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS follow_ups (
                id SERIAL PRIMARY KEY,
                lead_id INTEGER NULL REFERENCES leads(id) ON DELETE CASCADE,
                client_id INTEGER NULL REFERENCES clients(id) ON DELETE CASCADE,
                assigned_to INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
                title VARCHAR(200) NOT NULL,
                notes TEXT NULL,
                due_at TIMESTAMP NOT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'Pending' CHECK (status IN ('Pending','Completed','Cancelled')),
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function down()
    {
        $this->db->query('DROP TABLE IF EXISTS follow_ups');
    }
}
