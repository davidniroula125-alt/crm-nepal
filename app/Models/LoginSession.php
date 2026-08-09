<?php namespace App\Models;

use CodeIgniter\Model;

class LoginSession extends Model
{
    protected $table = 'login_sessions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['user_id', 'ip_address', 'user_agent', 'logged_in_at', 'logged_out_at'];

    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)->orderBy('logged_in_at', 'DESC')->findAll();
    }

    public function getActiveSessions(): array
    {
        return $this->where('logged_out_at', null)->findAll();
    }
}
