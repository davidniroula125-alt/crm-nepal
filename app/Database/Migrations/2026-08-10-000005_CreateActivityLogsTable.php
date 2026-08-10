<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityLogsTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS activity_logs (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
                action VARCHAR(150) NOT NULL,
                subject_type VARCHAR(100) NULL,
                subject_id INTEGER NULL,
                ip_address VARCHAR(45) NULL,
                device VARCHAR(255) NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function down()
    {
        $this->db->query('DROP TABLE IF EXISTS activity_logs');
    }
}
