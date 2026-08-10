<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteContentModel extends Model
{
    protected $table            = 'site_content';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'slug',
        'section',
        'key',
        'value',
        'type',
    ];

    /**
     * Get all content for a page slug as [section => [key => value]]
     */
    public function getPageContent(string $slug): array
    {
        $rows = $this->where('slug', $slug)->findAll();
        $content = [];
        foreach ($rows as $row) {
            $content[$row->section][$row->key] = $row->value;
        }
        return $content;
    }

    /**
     * Get a single content value
     */
    public function getValue(string $slug, string $section, string $key, string $default = ''): string
    {
        $row = $this->where('slug', $slug)->where('section', $section)->where('key', $key)->first();
        return $row ? $row->value : $default;
    }

    /**
     * Upsert content value
     */
    public function setContent(string $slug, string $section, string $key, string $value, string $type = 'text'): void
    {
        $existing = $this->where('slug', $slug)->where('section', $section)->where('key', $key)->first();
        if ($existing) {
            $this->update($existing->id, ['value' => $value, 'type' => $type]);
        } else {
            $this->insert([
                'slug'    => $slug,
                'section' => $section,
                'key'     => $key,
                'value'   => $value,
                'type'    => $type,
            ]);
        }
    }

    /**
     * Get all unique page slugs
     */
    public function getSlugs(): array
    {
        return $this->select('slug')->distinct()->get()->getResultArray();
    }
}
