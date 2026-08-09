<?php namespace App\Models;

use CodeIgniter\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'plan', 'created_at'];
    protected $createdField = 'created_at';
}
