<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'ip_address',
        'device',
        'created_at',
    ];

    protected $useTimestamps = false;

    public function log(int $userId, string $action, ?string $subjectType = null, ?int $subjectId = null): bool
    {
        $request = service('request');

        return $this->insert([
            'user_id'      => $userId,
            'action'       => $action,
            'subject_type' => $subjectType,
            'subject_id'   => $subjectId,
            'ip_address'   => $request->getIPAddress(),
            'device'       => $request->getUserAgent()->getAgentString(),
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }
}
