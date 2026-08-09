<?php namespace App\Models;

use CodeIgniter\Model;

class LoginAttempt extends Model
{
    protected $table = 'login_attempts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['ip_address', 'email', 'attempted_at'];

    public function logAttempt(string $email): void
    {
        $this->insert([
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'email' => $email,
            'attempted_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getRecentAttempts(string $email, int $minutes = 15): int
    {
        $since = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        return $this->where('email', $email)
                    ->where('attempted_at >=', $since)
                    ->countAllResults();
    }
}
