<?php

if (!function_exists('isLoggedIn')) {
    function isLoggedIn(): bool {
        return (bool) session()->get('user_id');
    }
}

if (!function_exists('getCurrentUser')) {
    function getCurrentUser(): ?array {
        return session()->get('user') ?: null;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool {
        $user = getCurrentUser();
        return $user && in_array($user['role'], ['super_admin', 'admin']);
    }
}

if (!function_exists('isStaff')) {
    function isStaff(): bool {
        $user = getCurrentUser();
        return $user && in_array($user['role'], ['super_admin', 'admin', 'team_member']);
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin(): bool {
        $user = getCurrentUser();
        return $user && $user['role'] === 'super_admin';
    }
}

if (!function_exists('log_activity')) {
    function log_activity(string $action, string $entityType = '', $entityId = null): void {
        $db = \Config\Database::connect();
        $user = getCurrentUser();
        $db->table('activity_log')->insert([
            'company_id' => $user['company_id'] ?? null,
            'user_id' => $user['id'] ?? null,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount): string {
        return 'NPR ' . number_format((float)$amount, 2);
    }
}

if (!function_exists('status_badge')) {
    function status_badge(string $status): string {
        $colors = [
            'lead' => '#3B82F6',
            'proposals' => '#F59E0B',
            'negotiation' => '#F97316',
            'closed_won' => '#10B981',
            'closed_lost' => '#EF4444',
            'pending' => '#F59E0B',
            'paid' => '#10B981',
            'overdue' => '#EF4444',
            'unread' => '#3B82F6',
            'read' => '#F59E0B',
            'replied' => '#10B981',
            'resolved' => '#10B981',
            'closed' => '#6B7280',
            'active' => '#10B981',
            'inactive' => '#6B7280',
        ];
        $color = $colors[$status] ?? '#6B7280';
        $label = ucwords(str_replace('_', ' ', $status));
        return '<span class="badge" style="background:'.$color.';color:#fff;padding:4px 10px;border-radius:12px;font-size:12px;">'.$label.'</span>';
    }
}

if (!function_exists('paginate')) {
    function paginate($builder, int $perPage = 10): array {
        $page = (int) (get_var('page') ?: 1);
        $total = $builder->countAllResults(false);
        $builder->limit($perPage, ($page - 1) * $perPage);
        return [
            'data' => $builder->get()->getResultArray(),
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage),
        ];
    }
}

if (!function_exists('get_var')) {
    function get_var(string $key, $default = null) {
        return request()->getGet($key) ?: $default;
    }
}

if (!function_exists('get_lang')) {
    function get_lang(): string {
        return session()->get('language') ?? 'en';
    }
}
