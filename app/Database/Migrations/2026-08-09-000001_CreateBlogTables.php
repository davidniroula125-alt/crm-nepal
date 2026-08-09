<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogTables extends Migration
{
    public function up()
    {
        // Blog Categories
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false, 'unique' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('blog_categories');

        // Blog Posts
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'category_id'      => ['type' => 'INT', 'null' => false],
            'author_id'        => ['type' => 'INT', 'null' => false],
            'title'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false, 'unique' => true],
            'featured_image'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'excerpt'          => ['type' => 'TEXT', 'null' => true],
            'body'             => ['type' => 'TEXT', 'null' => true],
            'tags'             => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'seo_title'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'status'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => false, 'default' => 'Draft'],
            'published_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'created_at'       => ['type' => 'TIMESTAMP', 'null' => false],
            'updated_at'       => ['type' => 'TIMESTAMP', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('category_id', 'blog_categories', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('author_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('blog_posts');
    }

    public function down()
    {
        $this->forge->dropTable('blog_posts');
        $this->forge->dropTable('blog_categories');
    }
}
