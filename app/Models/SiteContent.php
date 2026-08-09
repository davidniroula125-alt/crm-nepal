<?php namespace App\Models;

use CodeIgniter\Model;

class SiteContent extends Model
{
    protected $table = 'site_content';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['section', 'key_name', 'title', 'description', 'icon', 'sort_order', 'is_active', 'created_at', 'updated_at'];
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getBySection(string $section): array
    {
        return $this->where('section', $section)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getAllBySection(string $section): array
    {
        return $this->where('section', $section)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getByKey(string $keyName): ?array
    {
        return $this->where('key_name', $keyName)->where('is_active', 1)->first();
    }
}
