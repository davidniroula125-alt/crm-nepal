<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name',
        'email',
        'password_hash',
        'role',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'failed_login_attempts',
        'locked_until',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email address is already registered.',
        ],
    ];

    public function findByEmail(string $email): ?object
    {
        return $this->where('email', $email)->first();
    }

    public function incrementFailedAttempts(int $userId): void
    {
        $user = $this->find($userId);
        if (! $user) {
            return;
        }

        $attempts = $user->failed_login_attempts + 1;

        if ($attempts >= 5) {
            $this->update($userId, [
                'failed_login_attempts' => $attempts,
                'locked_until'          => date('Y-m-d H:i:s', strtotime('+30 minutes')),
            ]);
        } else {
            $this->update($userId, [
                'failed_login_attempts' => $attempts,
            ]);
        }
    }

    public function resetFailedAttempts(int $userId): void
    {
        $this->update($userId, [
            'failed_login_attempts' => 0,
            'locked_until'          => null,
        ]);
    }

    public function updateLastLogin(int $userId, string $ip): void
    {
        $this->update($userId, [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ip,
        ]);
    }

    public function updatePassword(int $userId, string $passwordHash): bool
    {
        return $this->update($userId, [
            'password_hash' => $passwordHash,
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
